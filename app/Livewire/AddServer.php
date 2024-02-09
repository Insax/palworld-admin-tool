<?php

namespace App\Livewire;

use App\Models\RconData;
use App\Models\Server;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class AddServer extends Component
{
    public $uses_whitelist = false;
    public $rcon = '';
    public $name = '';

    public array $availableRCON;

    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('servers'),
            ],
            'rcon' => 'required',
            'uses_whitelist' => 'boolean'
        ];
    }

    public function mount()
    {
        foreach (RconData::get() as $connection)
        {
            $this->availableRCON[] = ['value' => $connection->id, 'text' => $connection->host.':'.$connection->port];
        }
    }


    public function addServer()
    {
        $this->validate();
        $server = Server::create(['name' => $this->name, 'rcon_data_id' => $this->rcon, 'uses_whitelist' => $this->uses_whitelist]);

        Permission::create(['name' => 'View Server ['.$server->id.']']);
        Permission::create(['name' => 'Kick Server ['.$server->id.']']);
        Permission::create(['name' => 'Ban Server ['.$server->id.']']);
        Permission::create(['name' => 'Restart Server ['.$server->id.']']);
        Permission::create(['name' => 'Edit Whitelist Server ['.$server->id.']']);

        Toaster::success('Server created');
        return redirect()->route('server-dashboard', ['id' => $server->id]);
    }

    public function render()
    {
        return view('livewire.add-server')->layout('layouts.app');
    }
}
