<?php

namespace App\Support\RCON;

class PalworldRcon
{
    private PalworldRconConnection $connection;

    public function __construct(string $host, int $port, string $password, int $timeout)
    {
        $this->connection = new PalworldRconConnection($host, $port, $password, $timeout);
    }

    public function command(string $command) : string
    {
        try {
            $this->connection->sendCommand($command);
            return $this->connection->getResponse();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
