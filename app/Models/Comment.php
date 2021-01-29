<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\DateFormat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @property int|null $id
 * @property int|null $answer_id
 * @property int|null $user_id
 * @property string|null $content
 * @property string|null $uid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class Comment extends Model
{
    use DateFormat;

    protected $table = 'comment';

	protected $casts = [
		'answer_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'answer_id',
		'user_id',
		'content',
		'uid'
	];

	public function user() {
	    return $this->belongsTo(User::class,'user_id','id');
    }
}
