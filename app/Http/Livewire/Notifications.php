<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public function clearNotifications()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
