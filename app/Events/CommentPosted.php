<?php

namespace App\Events;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    public $parentComment;

    public $commenter;

    public $notifiables;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $parentComment, User $commenter, array $notifiables)
    {
        $this->comment = $comment;
        $this->parentComment = $parentComment;
        $this->commenter = $commenter;
        $this->users = $notifiables;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
