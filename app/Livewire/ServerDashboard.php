<?php

namespace App\Livewire;

use App\Models\JoinLeaveLog;
use App\Models\Player;
use App\Models\Server;
use Masmerise\Toaster\Toaster;
use Livewire\Component;
use Rcon;

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
        $server = Server::find($this->id);
        Rcon::kickPlayer($server, $player['player_id']);
        JoinLeaveLog::create(['player_id' => $player['id'], 'action' => JoinLeaveLog::$PLAYER_KICKED_USER]);
        Player::whereId($player['id'])->update(['online' => false]);
        Rcon::broadcast($server, 'Kicked_Player: '.$player['name']);
        Toaster::success('Player kicked');
    }

    public function banPlayer($player)
    {
        $server = Server::find($this->id);
        Rcon::banPlayer($server, $player['player_id']);
        JoinLeaveLog::create(['player_id' => $player['id'], 'action' => JoinLeaveLog::$PLAYER_BAN_USR]);
        Player::whereId($player['id'])->update(['online' => false]);
        Toaster::success('Player banned');
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
        $server = Server::find($this->id);
        Rcon::shutdownServer($server);
        Toaster::success('Shutdown Initialized');
    }

    public function render()
    {
        return view('livewire.server-dashboard')->layout('layouts.app');
    }
}
