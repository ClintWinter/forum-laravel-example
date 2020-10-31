<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Notifications\CommentPosted as NotificationsCommentPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
        Notification::send(
            $event->users,
            new NotificationsCommentPosted($event->comment, $event->parentComment, $event->commenter)
        );
    }
}
