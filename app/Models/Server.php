<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 *
 * @property int $id
 * @property string $name
 * @property string $rcon
 * @property bool $online
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $shutting_down
 * @property bool $uses_whitelist
 * @property Collection|Player[] $players
 * @property Collection|ServerWhitelist[] $server_whitelists
 * @package App\Models
 * @property-read int|null $players_count
 * @property-read int|null $server_whitelists_count
 * @method static \Illuminate\Database\Eloquent\Builder|Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereRcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereShuttingDown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereUsesWhitelist($value)
 * @mixin \Eloquent
 */
class Server extends Model
{
	protected $table = 'servers';

	protected $casts = [
		'online' => 'bool',
		'active' => 'bool',
		'shutting_down' => 'bool',
		'uses_whitelist' => 'bool'
	];

	protected $fillable = [
		'name',
		'rcon',
		'online',
		'active',
		'shutting_down',
		'uses_whitelist'
	];

	public function players()
	{
		return $this->hasMany(Player::class);
	}

	public function server_whitelists()
	{
		return $this->hasMany(ServerWhitelist::class);
	}
}
