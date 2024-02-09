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

class KickPlayerResponse extends Response
{

    protected function extractBody(array $lines): array
    {
        return ['kicked' => substr($this->getHeader(), 8)];
    }

    protected function isExpectedHeaderText(string $header): bool
    {
        return !strncmp('Kicked: ', $header, 8);
    }
}
