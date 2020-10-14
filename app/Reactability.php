<?php

namespace App;

use App\Models\Reaction;
use App\Models\User;

trait Reactability {

    public function upvote()
    {
        if ($this->hasReactionFrom(auth()->user(), 1)) {
            $this->unreact(auth()->user());
            return;
        }

        $this->unreact(auth()->User());
        $this->react(auth()->user(), 1);
        return;
    }

    public function downvote()
    {
        if ($this->hasReactionFrom(auth()->user(), -1)) {
            $this->unreact(auth()->User());
            return;
        }

        $this->unreact(auth()->user());
        $this->react(auth()->user(), -1);
        return;
    }

    public function reactions()
    {
        return $this->morphMany('App\Models\Reaction', 'reactable');
    }

    public function getReaction(User $user)
    {
        return $this->reactions()->where('user_id', $user->id)->first();
    }

    public function score()
    {
        return $this->reactions->sum(function($reaction) {
            return $reaction->value;
        });
    }

    public function react(User $user, $value)
    {
        $this->reactions()->create([
            'user_id' => $user->id,
            'value' => $value,
        ]);
    }

    public function unreact(User $user)
    {
        $this->reactions()->where('user_id', $user->id)->delete();
    }

    public function toggleReaction(User $user, $value)
    {
        if ($this->hasReactionFrom($user))
            return $this->unreact($user, $value);

        return $this->react($user, $value);
    }

    public function hasReactionFrom(User $user, $value = null)
    {
        $where = ['user_id' => $user->id];

        if ($value)
            $where['value'] = $value;

        return !! $this->reactions()->where($where)->count();
    }

}
