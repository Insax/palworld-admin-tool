<?php

namespace App\Livewire;

use App\Models\Server;
use Livewire\Component;

class ServerOverview extends Component
{
    public $servers;

    public function mount()
    {
        $this->servers = Server::with('rconData')->get();
    }

    public function toggleActiveServer(Server $server)
    {
        $server->active = !$server->active;
        $server->save();
        return redirect()->route('server-overview');
    }

    public function render()
    {
        return view('livewire.server-overview')->layout('layouts.app');
    }
}
