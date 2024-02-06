<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RconData
 *
 * @property int $id
 * @property string $host
 * @property int $port
 * @property string $password
 * @property int $timeout
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|Server[] $servers
 * @package App\Models
 * @property-read int|null $servers_count
 * @method static \Illuminate\Database\Eloquent\Builder|RconData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RconData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RconData query()
 * @method static \Illuminate\Database\Eloquent\Builder|RconData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RconData whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RconData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RconData wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RconData wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RconData whereTimeout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RconData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RconData extends Model
{
	protected $table = 'rcon_data';

	protected $casts = [
		'port' => 'int',
		'timeout' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'host',
		'port',
		'password',
		'timeout'
	];

	public function servers()
	{
		return $this->hasMany(Server::class, 'rcon_data_id');
	}
}
