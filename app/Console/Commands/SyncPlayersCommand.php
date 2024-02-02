<?php

namespace App\Console\Commands;

use App\Models\JoinAndLeave;
use App\Models\Player;
use App\Models\Server;
use App\Models\ServerWhitelist;
use Illuminate\Console\Command;
use RCON;

class SyncPlayersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pal:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes Players from a PalWorldServer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Server::whereActive(true)->get() as $server)
        {
            $onlinePlayers = array();
            $result = RCON::getPlayers($server->rcon);
            foreach ($result as $player) {
                if($player['player_id'] == 00000000)
                    continue;

                $onlinePlayers[] = $player['player_id'];

                $player['online'] = true;
                $player['server_id'] = $server->id;
                $players = Player::where(['player_id' => $player['player_id'], 'server_id' => $player['server_id']])->first();

                if(is_null($players))
                {
                    $newPlayer = Player::create($player);
                    JoinAndLeave::create(['player_id' => $newPlayer->id, 'action' => JoinAndLeave::$PLAYER_JOINED]);
                }
                else
                {
                    if($players->online == false)
                    {
                        JoinAndLeave::create(['player_id' => $players->id, 'action' => JoinAndLeave::$PLAYER_JOINED]);
                    }
                    $players->update($player);
                }
            }
            $offlinePlayers = Player::where('server_id', $server->id)->whereNotIn('player_id', $onlinePlayers)->whereOnline(true)->get();

            foreach ($offlinePlayers as $offlinePlayer)
            {
                $offlinePlayer->update(['online' => false]);
                JoinAndLeave::create(['player_id' => $offlinePlayer->id, 'action' => JoinAndLeave::$PLAYER_LEFT]);
            }

            if($server->uses_whitelist)
            {
                $whitelist = ServerWhitelist::where('server_id', $server->id)->get();
                $whitelistPlayers = array();
                foreach ($whitelist as $whitelistItem) {
                    $whitelistPlayers[] = $whitelistItem->player_id;
                }

                $notWhitelistedPlayers = Player::where('server_id', $server->id)->whereNotIn('player_id', $whitelistPlayers)->get();

                foreach ($notWhitelistedPlayers as $notWhitelistedPlayer) {
                    RCON::kickPlayer($server->rcon, $notWhitelistedPlayer->player_id);
                    $notWhitelistedPlayer->update(['online' => false]);
                    JoinAndLeave::create(['player_id' => $notWhitelistedPlayer->id, 'action' => JoinAndLeave::$PLAYER_KICKED_WHITELIST]);
                }
            }
        }
    }
}