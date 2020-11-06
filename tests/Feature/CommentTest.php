<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Comment;
use App\Events\CommentPosted;
use App\Http\Livewire\Comment as LivewireComment;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function comment_has_a_post_and_a_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $post = Post::factory()->create();

        $comment = $post->comments()->save(
            auth()->user()->comments()->make([
                'body' => 'this is the body'
            ])
        );

        $this->assertEquals($comment->post_id, $post->id);
        $this->assertEquals($comment->user_id, $user->id);
    }

    /** @test */
    public function component_mounts_with_post_and_replies()
    {
        Livewire::test(LivewireComment::class, ['comment' => $comment = Comment::factory()->create()])
            ->assertSet('post', $comment->post)
            ->assertSet('replies', $comment->replies);
    }

    /** @test */
    public function can_add_a_comment()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewireComment::class, ['comment' => $comment = Comment::factory()->create()])
            ->set('reply', $reply = 'here is my new comment body')
            ->call('addComment');

        $this->assertTrue(Comment::whereBody($reply)->whereParentId($comment->id)->exists());
    }

    /** @test */
    public function comment_body_is_required_and_must_be_5_characters_minimum()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewireComment::class, ['comment' => Comment::factory()->create()])
            ->call('addComment')
            ->assertHasErrors(['reply' => 'required'])

            ->set('reply', 'foo')
            ->call('addComment')
            ->assertHasErrors(['reply' => 'min'])

            ->set('reply', 'valid reply')
            ->call('addComment')
            ->assertHasNoErrors('reply');
    }

    /** @test */
    public function can_edit_the_comment()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewireComment::class, ['comment' => $comment = Comment::factory()->create()])
            ->set('comment.body', $reply = 'updated comment body')
            ->call('editComment');

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => $reply,
        ]);
    }

    /** @test */
    public function can_delete_the_comment()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewireComment::class, ['comment' => $comment = Comment::factory()->create()])
            ->assertDontSeeHtml('<p>[Deleted]</p>')
            ->call('deleteComment')
            ->assertSeeHtml('<p>[Deleted]</p>');

        $this->assertNull(Comment::find($comment->id));
    }

    /** @test */
    public function can_upvote_the_comment()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewireComment::class, ['comment' => $comment = Comment::factory()->create()])
            ->call('upvote');

        $this->assertEquals(1, $comment->fresh()->score());
    }

    /** @test */
    public function can_downvote_the_comment()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LivewireComment::class, ['comment' => $comment = Comment::factory()->create()])
            ->call('downvote');

        $this->assertEquals(-1, $comment->fresh()->score());
    }

    /** @test */
    public function adding_comment_dispatches_comment_posted_event()
    {
        Event::fake();

        $this->actingAs($user = User::factory()->create());

        Livewire::test(LivewireComment::class, ['comment' => $comment = Comment::factory()->create()])
            ->set('reply', $reply = 'here is my new comment body')
            ->call('addComment');

        Event::assertDispatched(CommentPosted::class, function(CommentPosted $event) use ($reply, $comment, $user) {
            return $event->comment->body === $reply &&
                   $event->comment->parent_id === $comment->id &&
                   $event->comment->user_id === $user->id;
        });
    }
}
