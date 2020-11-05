<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Comment;
use App\Http\Livewire\Post as LivewirePost;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function an_authorized_user_can_create_a_post()
    {
        $this->actingAs(User::factory()->create());

        $attributes = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];

        $this->post('/posts', $attributes);

        $this->assertDatabaseHas('posts', $attributes);

        $this->get('/posts')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_post_must_have_a_title_and_body()
    {
        $this->actingAs(User::factory()->create());

        $this->post('/posts')->assertSessionHasErrors(['title', 'body']);
    }

    /** @test */
    public function a_post_must_have_a_title_and_body_with_minimum_characters()
    {
        $this->actingAs(User::factory()->create());

        $attributes = [
            'title' => 'foo',
            'body' => 'bar baz',
        ];

        $this->post('/posts', $attributes)->assertSessionHasErrors(['title', 'body']);
    }

    /** @test */
    public function a_user_can_update_their_own_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $attributes = [
            'body' => $this->faker->paragraph,
        ];

        $this->patch('/posts/'.$post->id, $attributes)->assertRedirect('/posts/'.$post->id);

        $this->assertDatabaseHas('posts', $attributes);

        $this->get('/posts/'.$post->id)->assertSee($attributes['body']);
    }

    /** @test */
    public function a_user_cannot_update_another_users_post()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1);

        $post = Post::factory()->create([
            'user_id' => $user2->id,
        ]);

        $attributes = [
            'body' => $this->faker->paragraph,
        ];

        $this->patch('/posts/'.$post->id, $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('posts', $attributes);

        $this->get('/posts/'.$post->id)->assertDontSee($attributes['body']);
    }

    /** @test */
    public function a_user_can_delete_their_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('posts', $post->attributesToArray());

        $this->delete('/posts/'.$post->id)->assertRedirect();

        $this->get('/posts')->assertDontSee($post->title);
    }

    /** @test */
    public function a_user_cannot_delete_another_users_post()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1);

        $post = Post::factory()->create([
            'user_id' => $user2->id,
        ]);

        $this->delete('/posts/'.$post->id)->assertStatus(403);

        $this->assertDatabaseHas('posts', $post->attributesToArray());

        $this->get('/posts/'.$post->id)->assertSee($post->body);
    }

    /** Livewire Tests */

    /** @test */
    public function can_add_a_comment()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewirePost::class, ['post' => Post::factory()->create()])
            ->set('body', $body = 'this is a comment')
            ->call('addComment');

        $this->assertTrue(Comment::whereBody($body)->exists());
    }

    /** @test */
    public function comment_is_required_and_must_be_10_characters_minimum()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewirePost::class, ['post' => Post::factory()->create()])
            ->call('addComment')
            ->assertHasErrors(['body' => 'required'])

            ->set('body', 'asdf')
            ->call('addComment')
            ->assertHasErrors(['body' => 'min'])

            ->set('body', 'asdf asdf asdf asdf')
            ->call('addComment')
            ->assertHasNoErrors('body');
    }
}
