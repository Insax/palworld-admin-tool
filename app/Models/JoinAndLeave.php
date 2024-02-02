<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JoinAndLeave
 *
 * @property int $id
 * @property int $player_id
 * @property string $action
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Player $player
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave query()
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JoinAndLeave whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JoinAndLeave extends Model
{
	protected $table = 'join_and_leave';

	protected $casts = [
		'player_id' => 'int'
	];

	protected $fillable = [
		'player_id',
		'action'
	];

    public static string $PLAYER_JOINED = 'JOIN';
    public static string $PLAYER_LEFT = 'LEFT';
    public static string $PLAYER_KICKED_WHITELIST = 'KICKWL';
    public static string $PLAYER_KICKED_USER = 'KICKUSR';
    public static string $PLAYER_BAN_USR = 'BANUSR';

	public function player()
	{
		return $this->belongsTo(Player::class);
	}
}
