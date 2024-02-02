<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserOverview extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::get();
    }

    public function render()
    {
        return view('livewire.user-overview')->layout('layouts.app');
    }
}
