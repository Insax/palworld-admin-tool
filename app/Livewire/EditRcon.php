<?php

namespace App\Livewire;

use App\Gameserver\Communication\Responses\InfoResponse;
use App\Models\RconData;
use App\Support\RCON\PalworldRcon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditRcon extends Component
{
    public RconData $rconData;
    public int $port;
    public string $ip;
    public string $password = '';

    public bool $testSuccessful = false;

    public function rules()
    {
        return [
            'port' => 'required',
            'ip' => 'required',
            'password' => 'required',
            'testSuccessful' => [
                'required',
                Rule::in(true)
            ]
        ];
    }

    public function testConnection()
    {
        $rcon = new PalworldRcon($this->ip, $this->port, $this->password, 5);
        $result = new InfoResponse($rcon->command('info'));
        if ($result->getError() == 0) {
            $this->testSuccessful = true;
            Toaster::success("RCON Connection to ".$result->getResult()['serverName']." successful");
        } else
            Toaster::error($result->getHeader());

        $this->rconResponse = $result->getHeader();
        $this->quickServerName = $result->getResult()['serverName'];
    }

    public function mount($id)
    {
        $this->rconData = RconData::find($id);
        $this->port = $this->rconData->port;
        $this->ip = $this->rconData->host;
    }

    public function editRcon()
    {
        $this->testConnection();
        $this->validate();

        $this->rconData->update(['host' => $this->ip, 'port' => $this->port, 'password' => $this->password]);
        Toaster::success('RCON successfully edited');
        return redirect()->route('rcon-overview');
    }

    public function render()
    {
        return view('livewire.edit-rcon')->layout('layouts.app');
    }
}
