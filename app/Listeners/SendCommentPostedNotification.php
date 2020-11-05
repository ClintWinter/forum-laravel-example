<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Events\CommentPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CommentPosted as NotificationsCommentPosted;

class SendCommentPostedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentPosted  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        $notifiables = [];

        // add parent comment owner to notifiable if applicable
        if ($event->comment->parent_id) {
            $parentOwner = Comment::find($event->comment->parent_id)->user;

            if ($event->comment->user_id !== $parentOwner->id)
                $notifiables[] = $parentOwner;
        }

        // add post owner to notifiable if applicable
        if ($event->comment->user_id !== $event->comment->post->user_id) {
            $notifiables[] = $event->comment->post->user;
        }

        if (count($notifiables))
            Notification::send($notifiables, new NotificationsCommentPosted($event->comment));
    }
}
