<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Show extends Component
{
    public $user;

    public $activeTab = 'reactables';

    public $validTabs = ['reactables', 'reactions'];

    public function setTab($tab)
    {
        if (! in_array($tab, $this->validTabs)) {
            return;
        }

        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.user.show');
    }
}
