<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $users;

    public $sortField = 'score';

    public $sortFieldList = [
        'score' => 'score',
        'posts_count' => 'posts',
        'comments_count' => 'comments',
        'name' => 'name',
    ];

    public $sortDirection = 'desc';

    public $sortDirectionList = [
        'desc' => 'descending',
        'asc' => 'ascending',
    ];

    public function sort()
    {
        if (! in_array($this->sortField, array_keys($this->sortFieldList))) {
            return;
        }

        if (! in_array($this->sortDirection, array_keys($this->sortDirectionList))) {
            return;
        }

        $this->users = User::withCount(['posts', 'comments'])->get()
            ->map(function ($user) {
                return $user->setAttribute('score', $user->score());
            })
            ->{'sortBy'.($this->sortDirection === 'desc' ? 'Desc' : '')}($this->sortField);
    }

    public function render()
    {
        return view('livewire.users');
    }
}
