<?php

use App\Models\Article;
use App\Models\Enquiry;
use App\Models\MentorshipApplication;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Uses a real JPEG so the tests do not depend on the GD extension.
function sampleImage(string $name): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, file_get_contents(public_path('images/scenes/light.jpg')));
}

function owner(): User
{
    return User::factory()->create(['role' => 'owner']);
}

test('guests are sent to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.login'))->assertOk();
});

test('admins can sign in and out', function () {
    $user = User::factory()->create(['email' => 'team@example.com', 'password' => 'secret-password-1']);

    $this->post(route('admin.login.store'), ['email' => 'team@example.com', 'password' => 'secret-password-1'])->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($user);
    $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
    $this->assertGuest();
});

test('sign in is throttled after repeated failures', function () {
    User::factory()->create(['email' => 'team@example.com']);
    foreach (range(1, 5) as $i) {
        $this->post(route('admin.login.store'), ['email' => 'team@example.com', 'password' => 'wrong']);
    }

    $this->post(route('admin.login.store'), ['email' => 'team@example.com', 'password' => 'wrong'])->assertSessionHasErrors('email');
    expect(session('errors')->first('email'))->toStartWith('Too many sign-in attempts.');
});

test('every admin page loads for an owner', function (string $route) {
    $this->actingAs(owner())->get(route($route))->assertOk();
})->with(['admin.dashboard', 'admin.articles.index', 'admin.articles.create', 'admin.testimonials.index', 'admin.testimonials.create', 'admin.enquiries.index', 'admin.applications.index', 'admin.waitlist.index', 'admin.settings.edit', 'admin.team.index', 'admin.account.edit']);

test('roles limit what each person can manage', function () {
    $editor = User::factory()->create(['role' => 'editor']);
    $coordinator = User::factory()->create(['role' => 'coordinator']);

    $this->actingAs($editor)->get(route('admin.articles.index'))->assertOk();
    $this->actingAs($editor)->get(route('admin.enquiries.index'))->assertForbidden();
    $this->actingAs($editor)->get(route('admin.settings.edit'))->assertForbidden();
    $this->actingAs($coordinator)->get(route('admin.enquiries.index'))->assertOk();
    $this->actingAs($coordinator)->get(route('admin.articles.index'))->assertForbidden();
    $this->actingAs($coordinator)->get(route('admin.team.index'))->assertForbidden();
    $this->actingAs($coordinator)->get(route('admin.dashboard'))->assertOk()->assertDontSee('Blog &amp; Insights', false);
});

test('articles can be created with a cover, published and deleted', function () {
    Storage::fake('public');
    $this->actingAs(owner());

    $this->post(route('admin.articles.store'), [
        'title' => 'Designing for succession', 'category' => 'governance-succession', 'excerpt' => 'Why it matters.',
        'body' => "Opening.\n\n## Next", 'status' => 'published', 'is_featured' => '1',
        'cover' => sampleImage('cover.jpg'),
    ])->assertRedirect();

    $article = Article::firstWhere('slug', 'designing-for-succession');
    expect($article->published_at)->not->toBeNull()->and($article->is_featured)->toBeTrue()->and($article->is_sample)->toBeFalse();
    Storage::disk('public')->assertExists($article->cover_image);
    $this->get(route('insights.show', $article))->assertOk();

    $this->delete(route('admin.articles.destroy', $article))->assertRedirect(route('admin.articles.index'));
    Storage::disk('public')->assertMissing($article->cover_image);
    $this->assertModelMissing($article);
});

test('only one article is featured at a time', function () {
    $this->actingAs(owner());
    $first = Article::create(['title' => 'One', 'category' => 'leadership', 'excerpt' => 'x', 'body' => 'x', 'status' => 'published', 'is_featured' => true]);

    $this->post(route('admin.articles.store'), ['title' => 'Two', 'category' => 'leadership', 'excerpt' => 'x', 'body' => 'x', 'status' => 'published', 'is_featured' => '1']);

    expect($first->fresh()->is_featured)->toBeFalse();
});

test('testimonials can be added with a portrait and hidden', function () {
    Storage::fake('public');
    $this->actingAs(owner());

    $this->post(route('admin.testimonials.store'), [
        'quote' => 'Thoughtful and practical.', 'name' => 'Ngozi', 'context' => 'speaking', 'is_published' => '1',
        'portrait_file' => sampleImage('p.jpg'),
    ])->assertRedirect(route('admin.testimonials.index'));

    $testimonial = Testimonial::first();
    Storage::disk('public')->assertExists($testimonial->portrait);
    $this->get(route('home'))->assertSee('Thoughtful and practical.');

    $this->put(route('admin.testimonials.update', $testimonial), ['quote' => 'Thoughtful and practical.', 'name' => 'Ngozi', 'context' => 'speaking']);
    $this->get(route('home'))->assertDontSee('Thoughtful and practical.');
});

test('opening a new enquiry marks it as reviewing and notes can be saved', function () {
    $enquiry = Enquiry::create(['type' => 'speaking', 'name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'A keynote please.']);
    $this->actingAs(owner());

    $this->get(route('admin.enquiries.show', $enquiry))->assertOk()->assertSee('A keynote please.');
    expect($enquiry->fresh()->status)->toBe('reviewing');

    $this->put(route('admin.enquiries.update', $enquiry), ['status' => 'scheduled', 'internal_notes' => 'Confirmed for March'])->assertSessionHas('status');
    expect($enquiry->fresh())->status->toBe('scheduled')->internal_notes->toBe('Confirmed for March');
});

test('applications can be reviewed and exported', function () {
    $application = MentorshipApplication::create([
        'cohort' => 'Inaugural cohort', 'name' => 'Bola', 'email' => 'bola@example.com', 'role' => 'Associate', 'location' => 'Lagos',
        'goals' => 'g', 'outcomes' => 'o', 'motivation' => 'm', 'availability' => 'mostly', 'in_person' => 'yes', 'commitment' => 'c',
        'privacy_consented_at' => now(),
    ]);
    $this->actingAs(owner());

    $this->put(route('admin.applications.update', $application), ['status' => 'accepted', 'payment_status' => 'pending'])->assertSessionHas('status');
    expect($application->fresh()->status)->toBe('accepted');

    $csv = $this->get(route('admin.applications.export'))->assertOk()->streamedContent();
    expect($csv)->toContain('bola@example.com')->toContain('accepted');
});

test('settings are saved and change the public site', function () {
    $this->actingAs(owner())->put(route('admin.settings.update'), [
        'contact_email' => 'hello@example.com', 'linkedin_url' => 'https://linkedin.com/in/example', 'send_receipts' => '1',
    ])->assertSessionHas('status');

    expect(Setting::flag('book_waitlist_open'))->toBeFalse()->and(Setting::flag('send_receipts'))->toBeTrue();
    $this->get(route('contact'))->assertSee('hello@example.com');
});

test('cohort details and availability are managed from the cohort screen', function () {
    $this->actingAs(owner())->put(route('admin.cohort.update'), [
        'mentorship_status' => 'forthcoming', 'mentorship_cohort' => '2027 cohort', 'mentorship_fee' => '₦250,000',
    ])->assertSessionHas('status');

    expect(Setting::get('mentorship_status'))->toBe('forthcoming');
    $this->get(route('mentorship'))->assertSee('Opening soon')->assertSee('2027 cohort')->assertSee('₦250,000');
});

test('application dates open and close the form automatically', function () {
    Setting::put(['mentorship_status' => 'open', 'applications_open_on' => today()->addDays(3)->toDateString(), 'applications_close_on' => today()->addDays(20)->toDateString()]);
    expect(mentorship_status())->toBe('forthcoming');

    Setting::put(['applications_open_on' => today()->subDays(20)->toDateString(), 'applications_close_on' => today()->subDay()->toDateString()]);
    expect(mentorship_status())->toBe('closed');

    Setting::put(['applications_close_on' => today()->addDay()->toDateString()]);
    expect(mentorship_status())->toBe('open');
});

test('team members can be added but the last owner cannot be removed', function () {
    $me = owner();
    $this->actingAs($me);

    $this->post(route('admin.team.store'), ['name' => 'Coordinator', 'email' => 'coord@example.com', 'role' => 'coordinator', 'password' => 'a-strong-password'])->assertSessionHas('status');
    $coordinator = User::firstWhere('email', 'coord@example.com');
    expect($coordinator->role)->toBe('coordinator');

    $this->delete(route('admin.team.destroy', $me))->assertSessionHasErrors('team');
    $this->delete(route('admin.team.destroy', $coordinator))->assertSessionHas('status');
    $this->assertModelMissing($coordinator);
});

test('people can change their own password', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)->put(route('admin.account.update'), ['current_password' => 'wrong', 'password' => 'new-password-123', 'password_confirmation' => 'new-password-123'])->assertSessionHasErrors('current_password');
    $this->actingAs($user)->put(route('admin.account.update'), ['current_password' => 'old-password-123', 'password' => 'new-password-123', 'password_confirmation' => 'new-password-123'])->assertSessionHas('status');
});
