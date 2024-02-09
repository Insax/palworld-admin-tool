<?php

namespace App\Livewire;

use App\Gameserver\Communication\Rcon;
use App\Gameserver\Communication\Responses\InfoResponse;
use App\Models\RconData;
use App\Models\Server;
use App\Support\RCON\PalworldRcon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class AddRcon extends Component
{
    public $quickServer = true;
    public string $ip = '';
    public int $port = 0;
    public string $password = '';
    public string $rconResponse = '';
    public bool $testSuccessful = false;
    public string $quickServerName = '';

    public function rules()
    {
        return [
            'ip' => 'required',
            'port' => 'required',
            'password' => 'required',
            'testSuccessful' => [
                'required',
                Rule::in(true)
            ]
        ];
    }

    public function mount()
    {

    }

    public function testConnection()
    {
        $rcon = new PalworldRcon($this->ip, $this->port, $this->password, 5);
        $result = new InfoResponse($rcon->command('info'));
        if ($result->getError() == 0) {
            $this->testSuccessful = true;
            $this->quickServerName = $result->getResult()['serverName'];
            Toaster::success("RCON Connection to ".$result->getResult()['serverName']." successful");
        } else
            Toaster::error($result->getHeader());

        $this->rconResponse = $result->getHeader();
    }

    public function addRcon()
    {
        $this->testConnection();
        $this->validate();

        $rcon = RconData::create(['host' => $this->ip, 'port' => $this->port, 'password' => \Crypt::encrypt($this->password)]);

        if($this->quickServer) {
            $server = Server::create(['name' => $this->quickServerName, 'rcon_data_id' => $rcon->id]);
            return redirect()->route('server-dashboard', ['id' => $server->id]);
        }

        $this->reset(['ip', 'port', 'password', 'testSuccessful', 'quickServer', 'quickServerName', 'rconResponse']);
        Toaster::success('Rcon Connection Created');
    }

    public function render()
    {
        return view('livewire.add-rcon')->layout('layouts.app');
    }
}
