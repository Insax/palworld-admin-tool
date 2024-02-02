<?php

namespace App\Livewire;

use App\Models\Server;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditServer extends Component
{
    public $id;
    public Server $server;

    public array $availableRCON;
    public string $name;
    public string $rcon;
    public bool $uses_whitelist = false;

    public function mount($id)
    {
        foreach (config('rcon.connections') as $conn => $values)
        {
            if($conn == 'default')
                continue;
            $this->availableRCON[] = $conn;
        }
        $this->server = Server::find($id);
        $this->name = $this->server->name;
        $this->rcon = $this->server->rcon;
        $this->uses_whitelist = $this->server->uses_whitelist;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('servers')->ignore($this->server->name, 'name'),
            ],
            'rcon' => 'required',
            'uses_whitelist' => 'boolean'
        ];
    }

    public function updateServer()
    {
        $this->validate();
        $this->server->update($this->only(['name', 'rcon', 'uses_whitelist']));
        return redirect()->route('server-dashboard', ['id' => $this->server->id]);
    }

    public function render()
    {
        return view('livewire.edit-server')->layout('layouts.app');
    }
}
