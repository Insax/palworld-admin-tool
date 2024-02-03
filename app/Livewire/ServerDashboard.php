<?php

namespace App\Livewire;

use App\Models\JoinLeaveLog;
use App\Models\Player;
use App\Models\Server;
use RCON;
use Livewire\Component;

class ServerDashboard extends Component
{
    public $players;
    public $serverName;
    public $id;
    public $joinLeaveLog;

    public function mount($id)
    {
        $this->id = $id;
        $this->buildPlayerList();
        $this->buildJoinLeaveLog();
    }

    public function kickPlayer($player)
    {
        $rcon = Server::find($this->id)->rcon;
        RCON::kickPlayer($rcon, $player['player_id']);
        JoinLeaveLog::create(['player_id' => $player['id'], 'action' => JoinLeaveLog::$PLAYER_KICKED_USER]);
        return redirect()->route('server-dashboard', ['id' => $this->id]);
    }

    public function banPlayer($player)
    {
        $rcon = Server::find($this->id)->rcon;
        RCON::banPlayer($rcon, $player['player_id']);
        JoinLeaveLog::create(['player_id' => $player['id'], 'action' => JoinLeaveLog::$PLAYER_BAN_USR]);
        return redirect()->route('server-dashboard', ['id' => $this->id]);
    }

    public function buildPlayerList()
    {
        $this->players = Player::orderBy('online', 'desc')->where('server_id', $this->id)->orderBy('id', 'asc')->get();
        $this->serverName = Server::find($this->id)->name;
    }

    public function buildJoinLeaveLog()
    {
        $this->joinLeaveLog = JoinLeaveLog::whereRelation('player', 'server_id', $this->id)->orderBy('created_at', 'desc')->with('player')->limit(200)->get();
    }

    public function shutdownServer()
    {
        $rcon = Server::find($this->id)->rcon;
        \RCON::shutdownServer($rcon);
    }

    public function render()
    {
        return view('livewire.server-dashboard')->layout('layouts.app');
    }
}
