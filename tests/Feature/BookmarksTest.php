<?php

use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot access bookmarks endpoints', function () {
    $response = $this->get('/bookmarks');
    $response->assertStatus(302);
    // should redirect to login page
    $response->assertRedirect('/login');
});

test('authenticated user can fetch bookmarks', function () {
    $user = User::factory()->create();

    // create some bookmarks for this user
    Bookmark::create([
        'user_id' => $user->id,
        'title' => 'Song A',
        'url' => 'https://example.com/a',
        'tags' => ['Artist A'],
    ]);

    $this->actingAs($user);

    $resp = $this->getJson('/bookmarks');
    $resp->assertStatus(200);
    $resp->assertJsonCount(1);
    $resp->assertJsonFragment(['title' => 'Song A', 'url' => 'https://example.com/a']);
});

test('authenticated user can create a bookmark', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $payload = [
        'title' => 'New Song',
        'url' => 'https://example.com/new',
        'tags' => ['New Artist']
    ];

    $resp = $this->postJson('/bookmarks', $payload);
    $resp->assertStatus(201);
    $resp->assertJsonFragment(['title' => 'New Song', 'url' => 'https://example.com/new']);

    // ensure the DB has it
    $this->assertDatabaseHas('bookmarks', ['user_id' => $user->id, 'url' => 'https://example.com/new']);
});

test('guest cannot create a bookmark', function () {
    $payload = [
        'title' => 'Guest Song',
        'url' => 'https://example.com/guest',
    ];

    $resp = $this->post('/bookmarks', $payload);
    // guest should be redirected to login
    $resp->assertStatus(302);
    $resp->assertRedirect('/login');
});
