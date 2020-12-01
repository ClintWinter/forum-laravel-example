<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Reactables extends Component
{
    public $user;

    public $sortField = 'created_at';

    public $sortFieldList = [
        'reactions_sum_value' => 'score',
        'created_at' => 'created date',
    ];

    public $sortDirection = 'desc';

    public $sortDirectionList = [
        'desc' => 'descending',
        'asc' => 'ascending',
    ];

    public function toggleSortDirection()
    {
        $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
    }

    public function render()
    {
        return view('livewire.user.reactables', [
            'reactables' => $this->user->reactables()
                ->sortBy($this->sortField, SORT_REGULAR, $this->sortDirection === 'desc'),
        ]);
    }
}
