<?php

namespace App\Livewire;

use App\Models\Server;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ServerOverview extends Component
{
    public $servers;

    public function mount()
    {
        $this->servers = Server::with('rconData')->get();
    }

    public function deleteServer(Server $server)
    {
        $server->serverWhitelists()->delete();
        $server->players()->delete();
        $server->delete();
        Toaster::success('Server has been successfully deleted');
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
