<?php

namespace App\Livewire;

use App\Models\Player;
use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
