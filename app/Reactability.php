<?php

namespace App;

use App\Models\Reaction;
use App\Models\User;

trait Reactability {

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
        $reaction = new Reaction([
            'user_id' => $user->id,
            'value' => $value,
        ]);

        $this->reactions()->save($reaction);
    }

    public function unreact(User $user)
    {
        $this->reactions()->where('user_id', $user->id)->delete();
    }

    public function hasReactionFrom(User $user, $value = null)
    {
        $where = ['user_id' => $user->id];
        
        if ($value)
            $where['value'] = $value;

        return !! $this->reactions()->where($where)->count();
    }

    public function toggleReaction(User $user, $value)
    {
        if ($this->hasReactionFrom($user))
            return $this->unreact($user, $value);

        return $this->react($user, $value);
    }
    
}