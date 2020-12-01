<?php

namespace App\Http\Livewire\User;

use App\Models\Comment;
use Livewire\Component;

class Reactions extends Component
{
    public $user;

    public function render()
    {
        $reactions = $this->user->reactions()->with('reactable.user')->get()
            ->map(function ($reaction) {
                $display = $reaction->reactable instanceof Comment
                    ? $reaction->reactable->body
                    : $reaction->reactable->title;

                return $reaction->setAttribute('display', $display);
            })
            ->sortByDesc('created_at');

        return view('livewire.user.reactions', compact('reactions'));
    }
}
