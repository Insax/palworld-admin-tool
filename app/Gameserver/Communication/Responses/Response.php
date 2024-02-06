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

namespace App\Gameserver\Communication\Responses;

abstract class Response
{
    protected string $header;
    protected array $body;
    protected bool $isErrorResponse = false;
    private array $lines;
    private array $result;
    private int $error = 0;

    const ERROR_CONNECT = 1;
    const ERROR_AUTH = 2;
    const ERROR_CMD = 3;
    public function __construct(private readonly string $responseText)
    {
        $this->extractHeader();
        if($this->isErrorResponse)
            return;
        $this->result = $this->extractBody($this->lines);
    }

    public function getError()
    {
        return $this->error;
    }

    public function getResult() : array
    {
        return $this->result;
    }

    public function getHeader() : string
    {
        return $this->header;
    }

    protected abstract function extractBody(array $lines) : array;

    private function extractHeader()
    {
        $this->lines = explode("\n", $this->responseText);
        $this->header = array_shift($this->lines);
        $this->checkHeader();
    }

    protected abstract function isExpectedHeaderText(string $header) : bool;

    private function checkHeader()
    {
        if($this->isExpectedHeaderText($this->header))
            return;

        $this->isErrorResponse = true;

        if($this->header == 'Authorization rejected')
        {
            $this->error = self::ERROR_AUTH;
            \Log::alert($this->header);
        }
        elseif (strncmp('Could not connect to RCON', $this->header, 25))
        {
            $this->error = self::ERROR_CONNECT;
            \Log::critical($this->header);
        }
        else
        {
            $this->error = self::ERROR_CMD;
            \Log::info('Command Failed');
        }
    }
}
