<?php

namespace App;

use App\Models\Reaction;
use App\Models\User;

trait Reactability {

    public function reactions()
    {
        return $this->morphMany('App\Models\Reaction', 'reactable');
    }

    public function react(User $user, $value)
    {
        $reaction = $this->reactions()->create([
            'user_id' => $user->id,
            'value' => $value,
        ]);
        $this->refresh();

        return $reaction;
    }

    public function unreact(User $user)
    {
        $this->reactions()->where('user_id', $user->id)->delete();
        $this->refresh();
    }

    public function score()
    {
        return $this->reactions->sum('value');
    }

    public function toggleReaction(User $user, $value)
    {
        if ($this->hasReactionFrom($user))
            return $this->unreact($user, $value);

        return $this->react($user, $value);
    }

    public function upvote(User $user)
    {
        $reaction = $this->getReaction($user);

        if ($reaction === null) {
            $this->react($user, 1);
            return;
        }

        if ($reaction->value === 1) {
            $this->unreact($user);
            return;
        }

        $this->unreact($user);
        $this->react($user, 1);
        return;
    }

    public function isUpvotedBy(User $user)
    {
        return $this->hasReactionFrom($user) && $this->getReaction($user)->value === 1;
    }

    public function downvote(User $user)
    {
        $reaction = $this->getReaction($user);

        if ($reaction === null) {
            $this->react($user, -1);
            return;
        }

        if ($reaction->value === -1) {
            $this->unreact($user);
            return;
        }

        $this->unreact($user);
        $this->react($user, -1);
        return;
    }

    public function isDownvotedBy(User $user)
    {
        return $this->hasReactionFrom($user) && $this->getReaction($user)->value === -1;
    }

    public function getReaction(User $user)
    {
        return $this->reactions()->whereUserId($user->id)->first();
    }

    public function hasReactionFrom(User $user)
    {
        return $this->reactions()->whereUserId($user->id)->exists();
    }

}
