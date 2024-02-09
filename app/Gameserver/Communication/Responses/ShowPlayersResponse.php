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

class ShowPlayersResponse extends Response
{

    protected function extractBody(array $lines): array
    {
        $body = array();
        foreach ($lines as $line) {
            if(empty($line))
                break;

            $playerData = explode(",", $line);
            $body[] = [
                'name' => $playerData[0],
                'player_id' => $playerData[1],
                'steam_id' => $playerData[2]
            ];
        }
        return $body;
    }

    protected function isExpectedHeaderText(string $header): bool
    {
        return $header == 'name,playeruid,steamid';
    }
}
