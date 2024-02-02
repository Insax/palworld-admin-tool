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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Server $server
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerWhitelist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServerWhitelist extends Model
{
	protected $table = 'server_whitelist';

	protected $casts = [
		'server_id' => 'int'
	];

	protected $fillable = [
		'server_id',
		'player_id'
	];

	public function server()
	{
		return $this->belongsTo(Server::class);
	}
}
