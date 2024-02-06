<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Player
 *
 * @property int $id
 * @property string $player_id
 * @property string $name
 * @property string $steam_id
 * @property bool $online
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $server_id
 * @property Server|null $server
 * @property Collection|JoinLeaveLog[] $joinLeaveLogs
 * @package App\Models
 * @property-read int|null $joinLeaveLogs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereSteamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Player extends Model
{
	protected $table = 'players';

	protected $casts = [
		'online' => 'bool',
		'server_id' => 'int'
	];

	protected $fillable = [
		'player_id',
		'name',
		'steam_id',
		'online',
		'server_id'
	];

	public function server()
	{
		return $this->belongsTo(Server::class);
	}

	public function joinLeaveLogs()
	{
		return $this->hasMany(JoinLeaveLog::class);
	}
}
