<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 8.1
 *
 * @author     insa
 * @license    LICENSE.md
 * @category   CategoryName
 * @copyright  2024 insa
 * @package    PackageName
 */

namespace App\Support\RCON;

use App\Support\RCON\PalworldRconPacket;

class PalworldRconConnection
{
    private $socket;
    private string $response;
    private bool $authorized = false;
    public function __construct(private readonly string $host, private readonly int $port, private readonly string $password, private readonly int $timeout) { }

    public function sendCommand(string $command) : void
    {
        if(!$this->isConnected())
            $this->connect();

        if($this->password)
            $this->authorize();

        if(!$this->isAuthorized())
        {
            $this->disconnect();
            throw new \Exception("Authorization rejected", 0);
        }

        $this->sendPacket(PalworldRconPacket::ID_COMMAND, PalworldRconPacket::TYPE_SERVERDATA_EXECCOMMAND, $command);
    }

    public function getResponse()
    {
        $response = $this->receivePacket()->getBody();
        $this->disconnect();
        return $response;
    }

    public function sendPacket(int $id, int $type, string $body)
    {
        $packet = PalworldRconPacket::fromFields(['id' => $id, 'type' => $type, 'body' => $body]);
        fwrite($this->socket, $packet->getBytes());
    }

    public function receivePacket()
    {
        $bytes = fread($this->socket, 4);
        $size = unpack('V1size', $bytes);

        $bytes .= fread($this->socket, $size['size']);

        return PalworldRconPacket::fromBytes($bytes);
    }

    public function authorize()
    {
        $this->sendPacket(PalworldRconPacket::ID_AUTHORIZE, PalworldRconPacket::TYPE_SERVERDATA_AUTH, $this->password);
        $response = $this->receivePacket();
        if ($response->getId() == PalworldRconPacket::ID_AUTHORIZE &&
            $response->getType() == PalworldRconPacket::TYPE_SERVERDATA_AUTH_RESPONSE) {
            $this->authorized = true;
        }

        return $this->isAuthorized();
    }

    public function isAuthorized()
    {
        return $this->authorized;
    }

    public function isConnected() : bool
    {
        return is_resource($this->socket);
    }

    public function disconnect() : void
    {
        if(is_resource($this->socket))
            fclose($this->socket);
    }
    private function connect() : void
    {
        $this->socket = fsockopen($this->host, $this->port, $errorNumber, $errorMessage, $this->timeout);

        if(!$this->socket)
            throw new \Exception("Could not connect to RCON[$this->host]:[$this->port]: ".$errorMessage, $errorNumber);
    }
}
