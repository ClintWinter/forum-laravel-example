<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class Master extends Component
{
    public $switchableUsers;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->switchableUsers = User::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.master');
    }
}
