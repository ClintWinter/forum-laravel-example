<?php

namespace App\Http\Livewire\Comment;

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
        $this->post->comments()->save(
            auth()->user()->comments()->make(
                $this->comment->replies()->make([
                    'body' => $this->validate()['reply']
                ])->attributesToArray()
            )
        );

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
