<?php

namespace Tests\Feature;

use App\Events\CommentPosted;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Comment;
use Illuminate\Support\Facades\Event;
use App\Http\Livewire\Post as LivewirePost;
use App\Notifications\CommentPosted as CommentPostedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;

class PostsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function an_authorized_user_can_create_a_post()
    {
        $this->actingAs(User::factory()->create());

        $attributes = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];

        $this->post('/posts', $attributes);

        $this->assertDatabaseHas('posts', $attributes)
            ->get('/posts')
            ->assertSee($attributes['title']);
    }

    /** @test */
    public function a_guest_cannot_create_a_post()
    {
        $attributes = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];

        $this->post('/posts', $attributes)->assertRedirect('login');
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
        $user = User::factory()->hasPosts(1)->create();
        $this->actingAs($user);

        $post = $user->posts()->first();

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
        $nonPostOwner = User::factory()->create();
        $postOwner = User::factory()->hasPosts(1)->create();

        $this->actingAs($nonPostOwner);

        $post = $postOwner->posts()->first();

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
        $user = User::factory()->hasPosts(1)->create();

        $this->actingAs($user);

        $post = $user->posts()->first();

        $this->assertDatabaseHas('posts', $post->attributesToArray());

        $this->delete('/posts/'.$post->id)->assertRedirect();

        $this->get('/posts')->assertDontSee($post->title);
    }

    /** @test */
    public function a_user_cannot_delete_another_users_post()
    {
        $authUser = User::factory()->create();
        $postUser = User::factory()->hasPosts(1)->create();

        $this->actingAs($authUser);

        $post = $postUser->posts()->first();

        $this->delete('/posts/'.$post->id)->assertStatus(403);

        $this->assertDatabaseHas('posts', $post->attributesToArray());

        $this->get('/posts/'.$post->id)->assertSee($post->body);
    }

    /** @test */
    public function a_hot_post_displays_an_icon_to_users_in_the_posts_list()
    {
        $post = Post::factory()->create();

        $this->assertFalse($post->isHot());

        $this->get('/posts')
            ->assertDontSee('<i title="This post is trending." class="fas fa-fire text-orange-400"></i>', false);

        $post->comments()->saveMany(Comment::factory(11)->create());

        $this->assertTrue($post->isHot());

        $this->get('/posts')
            ->assertSee('<i title="This post is trending." class="fas fa-fire text-orange-500"></i>', false);
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

    /** @test */
    public function adding_comment_dispatches_CommentPosted_event()
    {
        Event::fake();

        $this->actingAs(User::factory()->create());

        Livewire::test(LivewirePost::class, ['post' => $post = Post::factory()->create()])
            ->set('body', $reply = 'asdf asdf asdf asdf')
            ->call('addComment');

        Event::assertDispatched(CommentPosted::class, function(CommentPosted $event) use ($post, $reply) {
            return $event->comment->post_id === $post->id &&
                   $event->comment->body === $reply &&
                   $event->comment->parent_id === null;
        });
    }

    /** @test */
    public function adding_comment_notifies_post_owner_with_CommentPosted_notification()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $this->actingAs(User::factory()->create());
        $user2 = User::factory()->create();

        Livewire::test(LivewirePost::class, ['post' => $post = Post::factory()->create(['user_id' => $user2->id])])
            ->set('body', $reply = 'asdf asdf asdf asdf')
            ->call('addComment');

        Notification::assertSentTo(
            [$post->user],
            function(CommentPostedNotification $notification) use ($reply) {
                return $notification->comment->body === $reply;
            }
        );
    }

    /** @test */
    public function adding_comment_doesnt_notify_post_owner_with_CommentPosted_notification_when_post_owner_is_comment_owner()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $this->actingAs($user = User::factory()->create());

        Livewire::test(LivewirePost::class, ['post' => $post = Post::factory()->create(['user_id' => $user->id])])
            ->set('body', 'asdf asdf asdf asdf')
            ->call('addComment');

        Notification::assertNotSentTo([$post->user], CommentPostedNotification::class);
    }
}
