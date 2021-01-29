<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\DateFormat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 *
 * @property int|null $id
 * @property int|null $answer_id
 * @property int|null $user_id
 * @property string|null $uid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class Like extends Model
{
    use DateFormat;

    protected $table = 'like';

	protected $casts = [
		'answer_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'answer_id',
		'user_id',
		'uid'
	];

	public function user(){
	    return $this->belongsTo(User::class,'user_id','id');
    }

    public function createItem($answer_id, $user_id): int
    {
        $model = new self();
        $model->answer_id = $answer_id;
        $model->user_id = $user_id;
        $model->save();

        return $model->id;
    }
}
