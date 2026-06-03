<?php

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('requires authentication for posts and users api endpoints', function () {
    $this->getJson('/api/posts')->assertStatus(401);
    $this->getJson('/api/posts/1')->assertStatus(401);
    $this->postJson('/api/posts', [])->assertStatus(401);

    $this->getJson('/api/users')->assertStatus(401);
    $this->getJson('/api/users/1')->assertStatus(401);
    $this->postJson('/api/users', [])->assertStatus(401);
});

it('allows authenticated users to fetch posts and users', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $post = Post::factory()->create(['user_id' => $user->id, 'title' => 'Pest Test Title']);

    // GET /api/posts
    $response = $this->getJson('/api/posts');
    $response->assertStatus(200)
             ->assertJsonStructure([
                 'data' => [
                     '*' => [
                         'id', 'title', 'slug', 'body', 'image', 'created_at', 'updated_at',
                         'user' => ['id', 'name', 'email']
                     ]
                 ],
                 'links', 'meta'
             ]);

    // GET /api/posts/{id}
    $response = $this->getJson("/api/posts/{$post->id}");
    $response->assertStatus(200)
             ->assertJson([
                 'data' => [
                     'id' => $post->id,
                     'title' => 'Pest Test Title',
                     'slug' => 'pest-test-title',
                     'user' => [
                         'id' => $user->id,
                         'name' => $user->name,
                     ]
                 ]
             ]);
});

it('validates post creation and generates slug automatically', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    // Test validation error
    $this->postJson('/api/posts', [
        'title' => 'hi', // too short
        'body' => 'short', // too short
    ])->assertStatus(422);

    // Test success and slug generation
    $response = $this->postJson('/api/posts', [
        'title' => 'My New Unique Awesome Post',
        'body' => 'This is a long body description exceeding ten characters.',
        'user_id' => $user->id,
        'slug' => 'attempted-manual-slug-which-should-be-ignored'
    ]);

    $response->assertStatus(201);
    $this->assertEquals('my-new-unique-awesome-post', $response->json('data.slug'));
});
