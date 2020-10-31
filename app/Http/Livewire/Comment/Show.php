<?php

namespace App\Http\Livewire\Comment;

use App\Events\CommentPosted;
use Livewire\Component;

class Show extends Component
{
    public $post;
    public $replies;
    public $comment;

    public $reply;

    protected $rules = [
        'comment.body' => '',
        'reply' => 'required|min:5',
    ];

    public function mount($comment)
    {
        $this->comment = $comment;
        $this->post = $this->comment->post;
        $this->replies = $this->comment->replies()
            ->with('user')
            ->orderBy('created_at')
            ->withTrashed()
            ->get();
    }

    public function addComment()
    {
        $comment = $this->post->comments()->save(
            auth()->user()->comments()->make(
                $this->comment->replies()->make([
                    'body' => $this->validate()['reply']
                ])->attributesToArray()
            )
        );

        $notifiables = [];
        if (auth()->user() != $this->post->user)
            $notifiables[] = $this->post->user;

        if (auth()->user() != $this->comment->user)
            $notifiables[] = $this->comment->user;

        if (! empty($notifiables))
            CommentPosted::dispatch($comment, $this->comment, auth()->user(), $notifiables);

        $this->replies = $this->comment->replies()
            ->with('user')
            ->orderBy('created_at')
            ->withTrashed()
            ->get();

        $this->reset(['reply']);
    }

    public function editComment()
    {
        $this->comment->save();
    }

    public function deleteComment()
    {
        $this->comment->delete();
    }

    public function upvote()
    {
        $this->comment->upvote();
        $this->comment->refresh();
    }

    public function downvote()
    {
        $this->comment->downvote();
        $this->comment->refresh();
    }

    public function render()
    {
        return view('livewire.comment.show');
    }
}
