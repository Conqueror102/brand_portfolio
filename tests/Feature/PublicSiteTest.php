<?php

use App\Models\Article;
use App\Models\Content;
use App\Models\MentorshipApplication;
use App\Models\Setting;
use App\Models\WaitlistSignup;
use Database\Seeders\SampleContentSeeder;

beforeEach(fn () => $this->seed(SampleContentSeeder::class));

test('every public page loads', function (string $route) {
    $this->get(route($route))->assertOk()->assertSee('Modupe');
})->with(['home', 'about', 'speaking', 'programmes', 'mentorship', 'impact', 'media', 'book', 'contact', 'privacy', 'insights.index']);

test('the homepage shows published articles and testimonials', function () {
    $article = Article::published()->first();

    $this->get(route('home'))->assertSee($article->title)->assertSee('In their');
});

test('published articles open and drafts return 404', function () {
    $published = Article::published()->first();
    $draft = Article::create(['title' => 'Hidden draft', 'category' => 'leadership', 'excerpt' => 'Draft', 'body' => 'Body text', 'status' => 'draft']);

    $this->get(route('insights.show', $published))->assertOk()->assertSee($published->title);
    $this->get(route('insights.show', $draft))->assertNotFound();
    $this->get(route('insights.index'))->assertDontSee('Hidden draft');
});

test('insights can be filtered and searched', function () {
    $this->get(route('insights.index', ['category' => 'governance-succession']))->assertSee('Succession is a system')->assertDontSee('Leading with quiet confidence');
    $this->get(route('insights.index', ['q' => 'nothing-matches-this']))->assertSee('No insights found');
});

test('article bodies are escaped', function () {
    $article = Article::create(['title' => 'Safe', 'category' => 'leadership', 'excerpt' => 'x', 'body' => "<script>alert(1)</script>\n\n## Heading", 'status' => 'published']);

    $this->get(route('insights.show', $article))->assertDontSee('<script>alert(1)</script>', false)->assertSee('<h2>Heading</h2>', false);
});

test('the contact page preselects a valid enquiry type', function () {
    $this->get(route('contact', ['type' => 'media']))->assertSee('value="media" selected', false);
});

test('enquiries with event details are stored', function () {
    $this->post(route('enquiries.store'), [
        'type' => 'panel', 'name' => 'Organiser', 'email' => 'org@example.com', 'proposed_date' => 'March 2027',
        'participants' => 120, 'message' => 'Moderating our annual managing partners panel.',
    ])->assertSessionHas('enquiry_saved');

    $this->assertDatabaseHas('enquiries', ['email' => 'org@example.com', 'participants' => 120, 'status' => 'new']);
});

test('honeypot enquiries are silently dropped', function () {
    $this->post(route('enquiries.store'), ['website' => 'spam.example', 'type' => 'speaking', 'name' => 'Bot', 'email' => 'bot@example.com', 'message' => 'Buy things now please'])
        ->assertSessionHas('enquiry_saved');

    $this->assertDatabaseCount('enquiries', 0);
});

function application(array $overrides = []): array
{
    return [
        'name' => 'Bola', 'email' => 'bola@example.com', 'role' => 'Associate', 'location' => 'Lagos',
        'goals' => str_repeat('Goal text. ', 3), 'outcomes' => str_repeat('Outcome text. ', 3),
        'motivation' => str_repeat('Motivation. ', 3), 'commitment' => str_repeat('Commitment. ', 3),
        'availability' => 'consistently', 'in_person' => 'yes', 'privacy' => '1', ...$overrides,
    ];
}

test('mentorship applications are stored when open', function () {
    $this->post(route('mentorship.apply'), application(['marketing_consent' => '1']))
        ->assertRedirect(route('mentorship').'#apply')->assertSessionHas('application_saved');

    $saved = MentorshipApplication::first();
    expect($saved->status)->toBe('submitted')
        ->and($saved->payment_status)->toBe('not_requested')
        ->and($saved->marketing_consent)->toBeTrue()
        ->and($saved->cohort)->toBe('Inaugural cohort');
});

test('applications require privacy consent', function () {
    $this->post(route('mentorship.apply'), application(['privacy' => null]))->assertSessionHasErrors('privacy');
    $this->assertDatabaseCount('mentorship_applications', 0);
});

test('applications are refused when the programme is closed', function () {
    Setting::put(['mentorship_status' => 'closed']);

    $this->get(route('mentorship'))->assertSee('Applications closed')->assertDontSee('Submit application');
    $this->post(route('mentorship.apply'), application())->assertForbidden();
});

test('the book waiting list stores one entry per email', function () {
    $this->post(route('waitlist.store'), ['name' => 'Chi', 'email' => 'Chi@Example.com', 'format' => 'print'])->assertSessionHas('waitlist_saved');
    $this->post(route('waitlist.store'), ['name' => 'Chi O', 'email' => 'chi@example.com', 'format' => 'digital']);

    expect(WaitlistSignup::count())->toBe(1)->and(WaitlistSignup::first()->format)->toBe('digital');
});

test('the waiting list can be closed', function () {
    Setting::put(['book_waitlist_open' => false]);

    $this->get(route('book'))->assertSee('waiting list is closed');
    $this->post(route('waitlist.store'), ['name' => 'Chi', 'email' => 'chi@example.com', 'format' => 'print'])->assertForbidden();
});

test('the header button follows the navigation content', function () {
    Content::saveDraft(['navigation.cta_label' => 'Join the cohort', 'navigation.cta_link' => '/programmes/mentorship']);
    Content::publish(['navigation.cta_label', 'navigation.cta_link']);

    $this->get(route('about'))->assertSee('Join the cohort')->assertSee('href="'.url('/programmes/mentorship').'"', false);
});
