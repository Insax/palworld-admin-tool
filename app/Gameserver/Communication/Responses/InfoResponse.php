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

use App\Gameserver\Communication\Responses\Response;

class InfoResponse extends Response
{
    protected function extractBody(array $lines): array
    {
        $regex = '/Server\[(v[\d.]+)]\s(.*)/';

        preg_match($regex, $this->getHeader(), $matches);
        return ['version' => $matches[1], 'serverName' => $matches[2]];
    }

    protected function isExpectedHeaderText(string $header) : bool
    {
        return !strncmp('Welcome to Pal Server', $header, 21);
    }
}
