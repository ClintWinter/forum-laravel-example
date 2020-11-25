<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\CommentPosted;

class Post extends Component
{
    public $post;
    public $comments;

    public $body;

    protected $rules = [
        'body' => 'required|min:10',
    ];

    protected $listeners = ['addComment' => 'addComment'];

    public function mount()
    {
        $this->comments = $this->post->comments()
            ->where('parent_id', 0)
            ->with('user')
            ->orderBy('created_at')
            ->withTrashed()
            ->get();
    }

    public function addComment()
    {
        $comment = $this->post->comments()->save(
            auth()->user()->comments()->make($this->validate())
        );

        CommentPosted::dispatch($comment);

        $this->comments = $this->post->comments()
            ->where('parent_id', 0)
            ->with('user')
            ->orderBy('created_at')
            ->withTrashed()
            ->get();

        $this->reset(['body']);
    }

    public function upvote()
    {
        $this->post->upvote(auth()->user());
    }

    public function downvote()
    {
        $this->post->downvote(auth()->user());
    }

    public function render()
    {
        return view('livewire.post');
    }
}
