<?php

namespace App\Console\Commands;

use App\Gameserver\Communication\Responses\Response;
use App\Gameserver\Communication\Responses\ShowPlayersResponse;
use App\Models\JoinLeaveLog;
use App\Models\Player;
use App\Models\Server;
use App\Models\ServerWhitelist;
use Illuminate\Console\Command;
use Rcon;

class SyncPlayersCommand extends Command
{
    private $servers;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'pal:sync';

    /**
     * The console command description.
     */
    protected $description = 'Synchronizes Players from a PalWorldServer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->servers = Server::whereActive(true)->with(['rconData', 'serverWhitelists', 'players'])->get();

        foreach ($this->servers as $server) {
            $response = Rcon::info($server);
            if($response->getError() != 0) {
                $this->handleUnreachableServer($server);
                continue;
            }

            if(!$server->online)
                $server->update(['online' => true]);

            $this->syncServerPlayers($server);
        }
    }

    private function handleUnreachableServer(Server $server)
    {
        $server->shutting_down = false;
        $server->online = false;
        $this->handleOfflinePlayers($server, []);
    }

    private function syncServerPlayers(Server $server)
    {
        $onlinePlayers = $this->getOnlinePlayers($server);


        $this->handleOfflinePlayers($server, $onlinePlayers);

        if ($server->uses_whitelist) {
            $this->handleNotWhitelistedPlayers($server);
        }
    }

    private function getOnlinePlayers(Server $server): array
    {
        $onlinePlayersIDs = [];
        $result = Rcon::showPlayers($server);

        foreach ($result->getResult() as $player) {
            if ($player['player_id'] === 00000000) continue;

            $onlinePlayersIDs[] = $player['player_id'];
            $this->updatePlayerStatus($player, $server);
        }

        return $onlinePlayersIDs;
    }

    private function updatePlayerStatus(array $player, Server $server): void
    {
        $playerData = [
            'online' => true,
            'server_id' => $server->id,
            'player_id' => $player['player_id']
        ];

        $playerModel = Player::firstOrNew($playerData);

        if ($playerModel->exists){
            if (!$playerModel->online) {
                $this->logPlayerAction($playerModel, JoinLeaveLog::$PLAYER_JOINED);
            }
            $playerModel->update($playerData);
        } else {
            $playerModel = Player::create($playerData);
            $this->logPlayerAction($playerModel, JoinLeaveLog::$PLAYER_JOINED);
        }
    }

    private function handleOfflinePlayers(Server $server, array $onlinePlayers): void
    {
        $offlinePlayers = Player::where('server_id', $server->id)
            ->whereNotIn('player_id', $onlinePlayers)
            ->whereOnline(true)
            ->get();

        foreach ($offlinePlayers as $offlinePlayer) {
            $offlinePlayer->update(['online' => false]);
            $this->logPlayerAction($offlinePlayer, JoinLeaveLog::$PLAYER_LEFT);
        }
    }

    private function handleNotWhitelistedPlayers(Server $server): void
    {
        $whitelistIDs = $server->serverWhitelists->pluck('player_id')->toArray();

        $notWhitelistedPlayers = Player::whereServerId($server->id)
            ->whereNotIn('player_id', $whitelistIDs)
            ->get();

        foreach ($notWhitelistedPlayers as $player) {
            Rcon::kickPlayer($server, $player->player_id);
            $player->update(['online' => false]);
            $this->logPlayerAction($player, JoinLeaveLog::$PLAYER_KICKED_WHITELIST);
        }
    }

    private function logPlayerAction(Player $player, string $action): void
    {
        JoinLeaveLog::create(['player_id' => $player->id, 'action' => $action]);
    }
}
