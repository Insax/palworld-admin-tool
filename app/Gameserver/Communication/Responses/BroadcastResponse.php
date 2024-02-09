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

class BroadcastResponse extends Response
{

    protected function extractBody(array $lines): array
    {
        return ['message' => substr($this->getHeader(),14, null)];
    }

    protected function isExpectedHeaderText(string $header): bool
    {
        return !strncmp('Broadcasted: ', $header, 13);
    }
}
