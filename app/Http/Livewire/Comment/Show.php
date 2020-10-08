<?php

namespace App\Http\Livewire\Comment;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $post;
    public $comments;
    public $comment;

    public $body;
    public $parent_id;

    protected $rules = [
        'body' => 'required|min:5',
        'parent_id' => 'required',
    ];

    public function mount()
    {
        $this->parent_id = $this->comment->id;
    }

    public function addComment()
    {
        $validData = $this->validate();

        $comment = new Comment($validData);

        $comment->user_id = Auth::user()->id;

        $this->post->comments()->save($comment);

        $this->post->refresh();

        $this->comments = $this->post->comments()
            ->with('user')
            ->orderBy('created_at')
            ->withTrashed()
            ->get()
            ->groupBy('parent_id')
            ->all();

        $this->reset(['body']);
    }

    public function render()
    {
        return view('livewire.comment.show');
    }
}
