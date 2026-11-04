<?php

use App\Mail\NewSubmission;
use App\Mail\Receipt;
use App\Models\Article;
use App\Models\Content;
use App\Models\Enquiry;
use App\Models\Item;
use App\Models\Media;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\User;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => $this->seed(SiteContentSeeder::class));

function editor(): User
{
    return User::factory()->create(['role' => 'editor']);
}

function realImage(string $name = 'photo.jpg'): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, file_get_contents(public_path('images/scenes/light.jpg')));
}

test('page edits stay as drafts until published', function () {
    $this->actingAs(editor());

    $this->put(route('admin.pages.update', 'about'), ['action' => 'draft', 'fields' => ['title' => 'A *new* about heading']])
        ->assertRedirect(route('admin.pages.edit', 'about'));

    $this->get(route('about'))->assertDontSee('A <em>new</em> about heading', false);
    $this->get(route('about', ['preview' => 1]))->assertSee('A <em>new</em> about heading', false)->assertSee('Preview: you are seeing unpublished changes');

    $this->put(route('admin.pages.update', 'about'), ['action' => 'publish', 'fields' => ['title' => 'A *new* about heading']]);
    auth()->logout();
    $this->get(route('about'))->assertSee('A <em>new</em> about heading', false);
});

test('preview is ignored for visitors and drafts can be discarded', function () {
    Content::saveDraft(['about.title' => 'Secret draft']);

    $this->get(route('about', ['preview' => 1]))->assertDontSee('Secret draft');

    $this->actingAs(editor())->put(route('admin.pages.update', 'about'), ['action' => 'discard'])->assertSessionHas('status');
    expect(Content::find('about.title')->has_draft)->toBeFalse();
});

test('the preview button opens the page with draft content', function () {
    $this->actingAs(editor())
        ->put(route('admin.pages.update', 'speaking'), ['action' => 'preview', 'fields' => ['title' => 'Draft speaking title']])
        ->assertRedirect('/speaking?preview=1');
});

test('homepage sections can be reordered and hidden', function () {
    $this->actingAs(editor())->put(route('admin.pages.update', 'home'), ['action' => 'publish', 'fields' => ['sections' => [
        ['key' => 'meet', 'order' => 2, 'visible' => '1'],
        ['key' => 'insights', 'order' => 1, 'visible' => '1'],
        ['key' => 'book', 'order' => 3],
    ]]])->assertSessionHas('status');

    expect(content('home.sections'))->toBe('insights:1,meet:1,book:0');
    $html = $this->get(route('home'))->assertOk()->getContent();
    expect($html)->not->toContain('id="book"')
        ->and(strpos($html, 'id="insights"'))->toBeLessThan(strpos($html, 'id="meet"'));
});

test('links in page content are validated', function () {
    $this->actingAs(editor())
        ->put(route('admin.pages.update', 'home'), ['action' => 'publish', 'fields' => ['hero_cta_link' => 'javascript:alert(1)']])
        ->assertSessionHasErrors('fields.hero_cta_link');
});

test('page images can be uploaded with a description', function () {
    Storage::fake('public');
    $this->actingAs(editor())->put(route('admin.pages.update', 'profile'), [
        'action' => 'publish', 'fields' => ['portrait' => ''], 'uploads' => ['portrait' => realImage()], 'upload_alt' => ['portrait' => 'Modupe at a desk'],
    ])->assertSessionHasNoErrors();

    $media = Media::sole();
    expect($media->alt)->toBe('Modupe at a desk')->and(content('profile.portrait'))->toBe($media->path);
    Storage::disk('public')->assertExists($media->path);
});

test('list items can be added, reordered, hidden and deleted', function () {
    $this->actingAs(editor());

    $this->post(route('admin.items.store', 'speaking_topics'), ['title' => 'Boards that work', 'body' => 'Governance in practice.', 'icon' => 'scale', 'is_published' => '1'])
        ->assertRedirect(route('admin.items.index', 'speaking_topics'));
    $item = Item::firstWhere('title', 'Boards that work');
    $this->get(route('speaking'))->assertSee('Boards that work');

    $this->post(route('admin.items.move', ['speaking_topics', $item->id]), ['direction' => 'up']);
    $titles = Item::ofType('speaking_topics')->pluck('title');
    expect($titles->search('Boards that work'))->toBe($titles->count() - 2);

    $this->put(route('admin.items.update', ['speaking_topics', $item->id]), ['title' => 'Boards that work', 'body' => 'Governance in practice.']);
    $this->get(route('speaking'))->assertDontSee('Boards that work');

    $this->delete(route('admin.items.destroy', ['speaking_topics', $item->id]));
    $this->assertModelMissing($item);
});

test('list items reject unknown types and unsafe links', function () {
    $this->actingAs(editor());

    $this->get(route('admin.items.index', 'nonsense'))->assertNotFound();
    $this->post(route('admin.items.store', 'organisations'), ['title' => 'Org', 'url' => 'javascript:alert(1)'])->assertSessionHasErrors('url');
});

test('programmes show their availability and image', function () {
    Storage::fake('public');
    $this->actingAs(editor())->post(route('admin.items.store', 'programmes'), [
        'title' => 'Executive circle', 'body' => 'For senior leaders.', 'category' => 'forthcoming', 'is_published' => '1', 'image_upload' => realImage(),
    ])->assertSessionHasNoErrors();

    $this->get(route('programmes'))->assertSee('Executive circle')->assertSee('Coming soon');
});

test('the media library uploads, records usage and protects files in use', function () {
    Storage::fake('public');
    $this->actingAs(editor());

    $this->post(route('admin.media.store'), ['files' => [realImage('stage.jpg')]])->assertSessionHas('status');
    $media = Media::sole();
    $this->put(route('admin.media.update', $media), ['alt' => 'Speaking on stage', 'caption' => 'IBA 2026'])->assertSessionHas('status');
    expect($media->fresh()->alt)->toBe('Speaking on stage');

    Content::saveDraft(['profile.portrait' => $media->path]);
    Content::publish(['profile.portrait']);
    $this->get(route('admin.media.edit', $media))->assertSee('Profile');
    $this->delete(route('admin.media.destroy', $media))->assertSessionHasErrors('media');

    Content::saveDraft(['profile.portrait' => '']);
    Content::publish(['profile.portrait']);
    $this->delete(route('admin.media.destroy', $media))->assertRedirect(route('admin.media.index'));
    Storage::disk('public')->assertMissing($media->path);
});

test('the media library rejects unsupported files', function () {
    $this->actingAs(editor())
        ->post(route('admin.media.store'), ['files' => [UploadedFile::fake()->create('script.php', 1, 'text/x-php')]])
        ->assertSessionHasErrors('files.0');
});

test('optional pages switch on and off from navigation', function () {
    $this->get(route('podcast.index'))->assertNotFound();
    $this->get(route('resources'))->assertNotFound();

    Content::saveDraft(['navigation.podcast_on' => '1', 'navigation.podcast_header' => '1', 'navigation.podcast_label' => 'The Podcast']);
    Content::publish(['navigation.podcast_on', 'navigation.podcast_header', 'navigation.podcast_label']);

    $episode = Item::create(['type' => 'podcast_episodes', 'title' => 'Building to last', 'subtitle' => 'A guest', 'body' => 'Show notes here.', 'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'is_published' => true]);
    $this->get(route('podcast.index'))->assertOk()->assertSee('Building to last');
    $this->get(route('podcast.show', $episode))->assertOk()->assertSee('Show notes here.')->assertSee('youtube-nocookie.com/embed/dQw4w9WgXcQ', false);
    $this->get(route('about'))->assertSee('The Podcast');
});

test('visitors can subscribe and unsubscribe', function () {
    $this->post(route('subscribe'), ['email' => 'Reader@Example.com', 'interests' => ['insights', 'book']])->assertSessionHas('subscribed');
    $this->post(route('subscribe'), ['email' => 'reader@example.com', 'interests' => ['speaking']]);

    $subscriber = Subscriber::sole();
    expect($subscriber->email)->toBe('reader@example.com')->and($subscriber->interests)->toEqualCanonicalizing(['insights', 'book', 'speaking']);

    $this->get(route('unsubscribe', $subscriber->token))->assertOk();
    expect($subscriber->fresh()->unsubscribed_at)->not->toBeNull();
});

test('subscribers can be filtered and exported by interest', function () {
    Subscriber::create(['email' => 'a@example.com', 'interests' => ['book'], 'consented_at' => now()]);
    Subscriber::create(['email' => 'b@example.com', 'interests' => ['insights'], 'consented_at' => now()]);
    $this->actingAs(User::factory()->create(['role' => 'coordinator']));

    $this->get(route('admin.subscribers.index', ['interest' => 'book']))->assertSee('a@example.com')->assertDontSee('b@example.com');
    $csv = $this->get(route('admin.subscribers.export', ['interest' => 'book']))->streamedContent();
    expect($csv)->toContain('a@example.com')->not->toContain('b@example.com');
});

test('enquiries can be assigned, scheduled and annotated', function () {
    $enquiry = Enquiry::create(['type' => 'speaking', 'name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'Keynote for our leadership summit.', 'status' => 'new']);
    $coordinator = User::factory()->create(['role' => 'coordinator', 'name' => 'Tolu']);
    $this->actingAs($coordinator);

    $this->get(route('admin.enquiries.show', $enquiry))->assertOk();
    expect($enquiry->fresh()->status)->toBe('reviewing');

    $this->put(route('admin.enquiries.update', $enquiry), ['status' => 'follow_up', 'assigned_to' => $coordinator->id, 'follow_up_on' => today()->toDateString()])->assertSessionHas('status');
    $this->post(route('admin.enquiries.note', $enquiry), ['body' => 'Called the organiser, waiting on the date.'])->assertSessionHas('status');

    $this->get(route('admin.enquiries.show', $enquiry))->assertSee('Called the organiser')->assertSee('Assigned to Tolu')->assertSee('Status changed to Follow-up');
    $this->get(route('admin.enquiries.index', ['assigned' => 'me']))->assertSee('Ada');
    $this->get(route('admin.enquiries.index', ['due' => 1]))->assertSee('Ada');
    expect($this->get(route('admin.enquiries.export'))->streamedContent())->toContain('ada@example.com')->toContain('Tolu');
});

test('editors cannot reach the inbox and coordinators cannot edit pages', function () {
    $this->actingAs(editor())->get(route('admin.enquiries.index'))->assertForbidden();
    $this->actingAs(User::factory()->create(['role' => 'coordinator']))->get(route('admin.pages.index'))->assertForbidden();
});

test('submissions notify the team and still save when email fails', function () {
    Mail::fake();
    Setting::put(['notification_email' => 'team@example.com', 'send_receipts' => true]);

    $this->post(route('enquiries.store'), ['type' => 'speaking', 'name' => 'Ada', 'email' => 'ada@example.com', 'message' => 'Keynote for our leadership summit.'])->assertSessionHas('enquiry_saved');

    Mail::assertSent(NewSubmission::class, fn ($mail) => $mail->hasTo('team@example.com'));
    Mail::assertSent(Receipt::class, fn ($mail) => $mail->hasTo('ada@example.com'));

    Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP down'));
    $this->post(route('enquiries.store'), ['type' => 'session', 'name' => 'Bisi', 'email' => 'bisi@example.com', 'message' => 'A leadership session for our team.'])->assertSessionHas('enquiry_saved');
    $this->assertDatabaseHas('enquiries', ['email' => 'bisi@example.com']);
});

test('testimonials can be featured on the homepage', function () {
    $this->actingAs(editor())->post(route('admin.testimonials.store'), [
        'quote' => 'A rare combination of clarity and warmth.', 'name' => 'Featured Person', 'context' => 'general', 'is_published' => '1', 'is_featured' => '1',
    ])->assertRedirect();

    $this->get(route('home'))->assertSee('Featured Person');
});

test('unpublished articles can be previewed by the team only', function () {
    $article = Article::create(['title' => 'Draft thinking', 'slug' => 'draft-thinking', 'excerpt' => 'An early idea.', 'body' => 'Body text.', 'category' => 'leadership', 'status' => 'draft', 'references' => 'Collins, J. Good to Great']);

    $this->get(route('insights.show', $article))->assertNotFound();
    $this->actingAs(editor())->get(route('admin.articles.preview', $article))->assertOk()->assertSee('Draft thinking')->assertSee('Good to Great');
});

test('every admin screen loads for the owner', function () {
    $this->actingAs(User::factory()->create(['role' => 'owner']));
    $routes = ['admin.dashboard', 'admin.pages.index', 'admin.items.overview', 'admin.media.index', 'admin.cohort.edit', 'admin.subscribers.index', 'admin.settings.edit', 'admin.enquiries.index', 'admin.applications.index'];
    foreach ($routes as $route) {
        $this->get(route($route))->assertOk();
    }
    foreach (array_keys(config('content.groups')) as $group) {
        $this->get(route('admin.pages.edit', $group))->assertOk();
    }
    foreach (array_keys(Arr::except(config('collections'), 'icons')) as $type) {
        $this->get(route('admin.items.index', $type))->assertOk();
        $this->get(route('admin.items.create', $type))->assertOk();
    }
    $item = Item::first();
    $this->get(route('admin.items.edit', [$item->type, $item->id]))->assertOk();
});

test('the photo reel shows public photos under the hero and needs a photo', function () {
    $this->actingAs(editor())->post(route('admin.items.store', 'moments'), ['title' => 'Keynote in Lagos', 'is_published' => '1'])->assertSessionHasErrors('image');

    Item::create(['type' => 'moments', 'title' => 'Keynote in Lagos', 'subtitle' => 'Business Forum', 'image' => 'images/scenes/light.jpg', 'is_published' => true]);
    $html = $this->get(route('home'))->assertSee('Keynote in Lagos')->getContent();
    expect(strpos($html, 'id="moments"'))->toBeLessThan(strpos($html, 'id="meet"'));
});

test('sections added later still appear when an older order was saved', function () {
    Content::saveDraft(['home.sections' => 'meet:1,insights:1']);
    Content::publish(['home.sections']);

    expect(collect(home_sections())->pluck(0)->all())->toContain('moments', 'cta');
    $this->actingAs(editor())->get(route('admin.pages.edit', 'home'))->assertSee('Photo reel');
});
