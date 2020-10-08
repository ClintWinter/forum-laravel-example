<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;

class CommentReaction extends Component
{
    public $comment;
    
    public function upvote()
    {
        if ($this->comment->hasReactionFrom(Auth::user(), 1)) {
            $this->comment->unreact(Auth::user());
            $this->comment->refresh();
            return;
        } elseif ($this->comment->hasReactionFrom(Auth::user(), -1)) {
            $this->comment->unreact(Auth::User());
        }

        $this->comment->react(Auth::user(), 1);
        $this->comment->refresh();
    }
    
    public function downvote()
    {
        if ($this->comment->hasReactionFrom(Auth::user(), 1)) {
            $this->comment->unreact(Auth::user());
        } elseif ($this->comment->hasReactionFrom(Auth::user(), -1)) {
            $this->comment->unreact(Auth::User());
            $this->comment->refresh();
            return;
        }

        $this->comment->react(Auth::user(), -1);
        $this->comment->refresh();
    }

    public function render()
    {
        return view('livewire.comment-reaction');
    }
}
