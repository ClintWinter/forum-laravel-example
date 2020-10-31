<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentPosted extends Notification
{
    use Queueable;

    public $comment;

    public $parentComment;

    public $commenter;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $parentComment, User $commenter)
    {
        $this->comment = $comment;
        $this->parentComment = $parentComment;
        $this->commenter = $commenter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $result = [
            'commenter' => $this->commenter,
            'comment' => $this->comment,
        ];

        if ($this->parentComment)
            $result[] = $this->parentComment;

        return $result;
    }
}
