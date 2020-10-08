<?php

namespace App\Http\Livewire\Post;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Show extends Component
{
    public $post;
    public $comments;

    public $body;

    protected $rules =[
        'body' => 'required|min:10',
    ];

    protected $listeners = ['addComment' => 'addComment'];

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
        return view('livewire.post.show');
    }
}
