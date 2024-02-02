<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServerWhitelist
 * 
 * @property int $id
 * @property int $server_id
 * @property string $player_id
 * @property string $steam_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Server $server
 *
 * @package App\Models
 */
class ServerWhitelist extends Model
{
	protected $table = 'server_whitelist';

	protected $casts = [
		'server_id' => 'int'
	];

	protected $fillable = [
		'server_id',
		'player_id',
		'steam_id'
	];

	public function server()
	{
		return $this->belongsTo(Server::class);
	}
}
