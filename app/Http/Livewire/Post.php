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

        $notifiables = [];
        if (auth()->user() != $this->post->user)
            $notifiables[] = $this->post->user;

        if (! empty($notifiables))
            CommentPosted::dispatch($comment, null, auth()->user(), $notifiables);

        $this->comments = $this->post->comments()
            ->where('parent_id', 0)
            ->with('user')
            ->orderBy('created_at')
            ->withTrashed()
            ->get();

        $this->reset(['body']);
    }

    public function render()
    {
        return view('livewire.post');
    }
}
