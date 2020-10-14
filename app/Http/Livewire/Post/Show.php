<?php

namespace App\Http\Livewire\Post;

use Livewire\Component;

class Show extends Component
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
        $this->post->comments()->save(
            auth()->user()->comments()->make($this->validate())
        );

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
        return view('livewire.post.show');
    }
}
