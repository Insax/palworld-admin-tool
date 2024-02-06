<?php

namespace App\Livewire;

use App\Models\RconData;
use App\Models\Server;
use Livewire\Component;

class RconOverview extends Component
{
    public $connections;

    public function mount()
    {
        $this->connections = RconData::get();
    }

    public function toggleActiveServer(Server $server)
    {
        $server->active = !$server->active;
        $server->save();
        return redirect()->route('server-overview');
    }

    public function render()
    {
        return view('livewire.rcon-overview')->layout('layouts.app');
    }
}
