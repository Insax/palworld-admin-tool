<?php

namespace App\Gameserver\Communication;

use App\Gameserver\Communication\Responses\BroadcastResponse;
use App\Gameserver\Communication\Responses\InfoResponse;
use App\Gameserver\Communication\Responses\KickPlayerResponse;
use App\Gameserver\Communication\Responses\BanPlayerResponse;
use App\Gameserver\Communication\Responses\Response;
use App\Gameserver\Communication\Responses\SaveResponse;
use App\Gameserver\Communication\Responses\ShowPlayersResponse;
use App\Models\Server;
use App\Support\RCON\PalworldRcon;

class Rcon
{
    public function info(Server $server) : Response
    {
        $rcon = new PalworldRcon($server->rconData->host, $server->rconData->port, \Crypt::decrypt($server->rconData->password), $server->rconData->timeout);
        $response = $rcon->command('info');
        return new InfoResponse($response);
    }

    public function showPlayers(Server $server) : Response
    {
        $rcon = new PalworldRcon($server->rconData->host, $server->rconData->port, \Crypt::decrypt($server->rconData->password), $server->rconData->timeout);
        $response = $rcon->command('showPlayers');
        return new ShowPlayersResponse($response);
    }

    public function kickPlayer(Server $server, string|int $playerId) : Response
    {
        $rcon = new PalworldRcon($server->rconData->host, $server->rconData->port, \Crypt::decrypt($server->rconData->password), $server->rconData->timeout);
        $response = $rcon->command("kick $playerId");
        return new KickPlayerResponse($response);
    }

    public function banPlayer(Server $server, string|int $playerId) : Response
    {
        $rcon = new PalworldRcon($server->rconData->host, $server->rconData->port, \Crypt::decrypt($server->rconData->password), $server->rconData->timeout);
        $response = $rcon->command("ban $playerId");
        return new BanPlayerResponse($response);
    }

    public function broadcast(Server $server, string $message) : Response
    {
        $message = str_replace($message, ' ', '\x1f');
        $rcon = new PalworldRcon($server->rconData->host, $server->rconData->port, \Crypt::decrypt($server->rconData->password), $server->rconData->timeout);
        $response = $rcon->command("broadcast $message");
        return new BroadcastResponse($response);
    }

    public function save(Server $server)
    {
        $rcon = new PalworldRcon($server->rconData->host, $server->rconData->port, \Crypt::decrypt($server->rconData->password), $server->rconData->timeout);
        $response = $rcon->command("save");
        return new SaveResponse($response);
    }
}
