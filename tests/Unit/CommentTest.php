<?php

namespace Tests\Unit;

use App\Events\CommentPosted;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Comment;
use Illuminate\Support\Facades\Event;
use App\Http\Livewire\Comment\Show as CommentShow;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

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
    public function adding_comment_dispatches_comment_posted_event()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Event::fake();

        $comment = Comment::factory()->create();

        $livewire = Livewire::test(CommentShow::class, ['comment' => $comment])
            ->assertSet('post', $comment->post);

        $reply = 'here is my new comment body';

        $livewire->set('reply', $reply)
            ->call('addComment');

        Event::assertDispatched(function(CommentPosted $event) use ($reply, $comment, $user) {
            return $event->comment->body === $reply
                && $event->parentComment->id === $comment->id
                && $event->commenter->id === $user->id
                && in_array( $comment->user, $event->notifiables )
                && in_array( $comment->post->user, $event->notifiables );
        });
    }
}
