<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 *
 * @property int $id
 * @property string $name
 * @property string $rcon
 * @property string $storage
 * @property bool $online
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereRcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereStorage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Server extends Model
{
	protected $table = 'servers';

	protected $casts = [
		'online' => 'bool',
		'active' => 'bool'
	];

	protected $fillable = [
		'name',
		'rcon',
		'uses_whitelist',
        'shutting_down',
		'online',
		'active'
	];

    public static function getServerCount()
    {
        if(Auth::check())
            return true;
    }
}
