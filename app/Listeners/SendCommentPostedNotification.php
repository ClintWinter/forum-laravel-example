<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Events\CommentPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CommentPosted as CommentPostedNotification;

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
        if (count($notifiables = $this->getNotifiables($event)))
            Notification::send($notifiables, new CommentPostedNotification($event->comment));
    }

    protected function getNotifiables(CommentPosted $event)
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

        return $notifiables;
    }
}
