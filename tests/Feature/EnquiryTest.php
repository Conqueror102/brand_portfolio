<?php

use Illuminate\Support\Facades\DB;

test('a valid engagement enquiry is persisted before confirmation', function () {
    $this->post(route('enquiries.store'), [
        'type' => 'speaking',
        'name' => 'Preview Visitor',
        'email' => 'preview@example.com',
        'organisation' => 'Example organisation',
        'message' => 'A leadership keynote for our annual conference.',
    ])->assertSessionHas('enquiry_saved');

    $this->assertDatabaseHas('enquiries', [
        'email' => 'preview@example.com',
        'type' => 'speaking',
        'status' => 'new',
    ]);
});

test('invalid enquiries do not create a record', function () {
    $this->from(route('home'))->post(route('enquiries.store'), [
        'type' => 'unexpected',
        'name' => '',
        'email' => 'invalid',
        'message' => 'short',
    ])->assertSessionHasErrors(['type', 'name', 'email', 'message']);

    expect(DB::table('enquiries')->count())->toBe(0);
});

test('"something else" stores the type chosen from the dropdown', function () {
    $this->post(route('enquiries.store'), [
        'type' => 'other',
        'type_other' => 'mentorship',
        'name' => 'Preview Visitor',
        'email' => 'other@example.com',
        'message' => 'I would like to know more about mentorship.',
    ])->assertSessionHas('enquiry_saved');

    $this->assertDatabaseHas('enquiries', ['email' => 'other@example.com', 'type' => 'mentorship']);
});

test('the contact form offers keynote, panel, workshop and leadership retreat', function () {
    $this->get(route('contact', ['type' => 'panel']))
        ->assertOk()
        ->assertSee('Keynote')->assertSee('Panel')->assertSee('Workshop')->assertSee('Leadership retreat')
        ->assertSee('value="panel" required checked', false);
});
