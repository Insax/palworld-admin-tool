<?php

namespace App\Livewire;

use App\Models\RconData;
use App\Models\Server;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class RconOverview extends Component
{
    public $connections;

    public function mount()
    {
        $this->connections = RconData::get();
    }

    public function deleteRcon(RconData $rconData)
    {
        $serverExists = false;
        foreach ($rconData->servers as $server)
        {
            Toaster::error('Can\'t delete RCON, Server '. $server->name .' is still connected to it.');
            $serverExists = true;
        }

        if(!$serverExists) {
            $rconData->delete();
            Toaster::success('RCON successfully deleted.');
        }
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
