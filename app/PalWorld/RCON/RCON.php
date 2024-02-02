<?php

namespace App\PalWorld\RCON;

use App\Models\JoinAndLeave;
use App\Models\Server;

class RCON implements ConnectionInterface
{
    /**
     * Default connection name
     *
     * @var string
     */
    public $defaultConnectionName;

    /**
     * Create new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->connections = [];
        $this->defaultConnectionName = config('rcon.default', 'default');
    }

    /**
     * Make connection with given name in config.
     *
     * @param string $name
     * @return Connection
     */
    protected function makeConnection($name)
    {
        $config = $this->getConnectionConfig($name);

        if (is_null($config)) {
            throw new Exception("Connection $name does not exists in config");
        }

        $connection = new Connection($config['host'], $config['port'], $config['timeout'], $name);

        if (array_key_exists('password', $config) && isset($config['password'])) {
            $connection->authorize($config['password']);
        }

        return $this->connections[$name] = $connection;
    }

    /**
     * Return connection config by its name.
     *
     * @param string $name
     * @return array
     */
    public function getConnectionConfig($name)
    {
        return config('rcon.connections.' . $name);
    }

    /**
     * Return given connection by its name. If connection is not
     * established creates new connection.
     *
     * @param string $name
     * @return Connection
     */
    public function connection($name)
    {
        if (! array_key_exists($name, $this->connections)) {
            $this->makeConnection($name);
        }

        return $this->connections[$name];
    }

    /**
     * Return default connection set in config.
     *
     * @return Connection
     */
    public function defaultConnection()
    {
        return $this->connection($this->defaultConnectionName);
    }

    /**
     * Check if default connection to RCON server is established.
     *
     * @return bool
     */
    public function isConnected()
    {
        if (! array_key_exists($this->defaultConnectionName, $this->connections)) {
            return false;
        }

        return $this->defaultConnection()
            ->isConnected();
    }

    /**
     * Sends packet to default connection.
     *
     * @param int $id
     * @param int $type
     * @param string $body
     * @return Packet
     */
    public function send($id, $type, $body)
    {
        return $this->defaultConnection()
            ->send($id, $type, $body);
    }

    /**
     * Check if connection default is authorized.
     *
     * @return bool
     */
    public function isAuthorized()
    {
        if (! $this->isConnected()) {
            return false;
        }

        return $this->defaultConnection()
            ->isAuthorized();
    }

    /**
     * Authorize default connection with given password.
     *
     * @param string $password
     * @return bool
     */
    public function authorize($password)
    {
        return $this->defaultConnection()
            ->authorize($password);
    }

    /**
     * Execute given command on default RCON server.
     *
     * @param string $command
     * @return string
     * @throws Exception
     */
    public function command($command)
    {
        return $this->defaultConnection()
            ->command($command);
    }

    public function getPlayers($rcon)
    {
        try {
            $result = $this->connection($rcon)->command('showPlayers');
            //First split return text by lines, then by commas
            $lines = explode("\n", $result);
            $players = [];
            array_shift($lines);
            foreach ($lines as $line) {
                if(empty($line))
                    break;

                $playerData = explode(",", $line);
                $players[] = [
                    'name' => $playerData[0],
                    'player_id' => $playerData[1],
                    'steam_id' => $playerData[2]
                ];
            }
            $servers = Server::where('rcon', $rcon)->get();
            foreach ($servers as $server) {
                $server->update(['online' => true]);
            }
            return $players;
        } catch (Exception $ex) {
            return [];
        }
    }

    public function shutdownServer($rcon)
    {
        $this->connection($rcon)->command('broadcast Restart_triggered_('.\Auth::user()->name.')');
        $this->connection($rcon)->command('save');
        $this->connection($rcon)->command('shutdown 20');
        $servers = Server::where('rcon', $rcon)->get();
        foreach ($servers as $server)
        {
            $server->update(['shutting_down' => true]);
        }
    }

    public function kickPlayer($rcon, $player_id)
    {
        $this->connection($rcon)->command('KickPlayer '.$player_id);
    }

    public function banPlayer($rcon, $player_id)
    {
        $this->connection($rcon)->command('BanPlayer '.$player_id);
    }
}
