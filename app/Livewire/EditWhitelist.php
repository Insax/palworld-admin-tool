<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Server;
use App\Models\ServerWhitelist;
use Livewire\Component;

class EditWhitelist extends Component
{
    public $id;
    public $serverName;
    public $players;
    public $newPlayerId;

    public $unkWhitelist;

    public function mount($id)
    {
        $this->id = $id;
        $this->serverName = Server::find($id)->name;
        $wl = ServerWhitelist::where('server_id', $id)->pluck('player_id');
        $this->players = Player::where('server_id', $id)->whereIn('player_id', $wl)->get();
        $player_ids = array();
        foreach (Player::where('server_id', $id)->get() as $player) {
            $player_ids[] = $player->player_id;
        }
        $this->unkWhitelist = ServerWhitelist::where('server_id', $id)->whereNotIn('player_id', $player_ids)->pluck('player_id');
    }

    public function removePlayer($player_id)
    {
        ServerWhitelist::where('server_id', $this->id)->where('player_id', $player_id)->delete();
        return redirect()->route('edit-whitelist', ['id' => $this->id]);
    }

    public function addPlayer()
    {
        ServerWhitelist::create(['server_id' => $this->id, 'player_id' => $this->newPlayerId]);
        return redirect()->route('edit-whitelist', ['id' => $this->id]);
    }

    public function render()
    {
        return view('livewire.edit-whitelist')->layout('layouts.app');
    }
}
