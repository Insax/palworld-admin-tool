<?php

namespace App\Livewire;

use App\Models\Server;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class AddServer extends Component
{
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
        foreach (config('rcon.connections') as $conn => $values)
        {
            if($conn == 'default')
                continue;
            $this->availableRCON[] = $conn;
        }
    }


    public function addServer()
    {
        $this->validate();
        $server = Server::create($this->only(['name', 'rcon', 'uses_whitelist']));

        Permission::create(['name' => 'View Server ['.$server->id.']']);
        Permission::create(['name' => 'Kick Server ['.$server->id.']']);
        Permission::create(['name' => 'Ban Server ['.$server->id.']']);
        Permission::create(['name' => 'Restart Server ['.$server->id.']']);
        Permission::create(['name' => 'Edit Whitelist Server ['.$server->id.']']);

        return redirect()->route('server-dashboard', ['id' => $server->id]);
    }

    public function render()
    {
        return view('livewire.add-server')->layout('layouts.app');
    }
}