<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\DateFormat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 *
 * @property int $id
 * @property int|null $emotion_id
 * @property int $user_id
 * @property string $content
 * @property string|null $uid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comment
 * @property-read int|null $comment_count
 * @property-read \App\Models\Emotion|null $emotion
 * @property-read mixed $is_like
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $like
 * @property-read int|null $like_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereEmotionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answer whereUserId($value)
 * @mixin \Eloquent
 */
class Answer extends Model
{
    use DateFormat;

	protected $table = 'answer';

	protected $casts = [
		'emotion_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'emotion_id',
		'user_id',
		'content',
		'uid'
	];

	protected $hidden = ['uid'];

    protected $appends = ['is_like'];

    public function getIsLikeAttribute()
    {
        if (!auth()->check()) {
            return $this->attributes['is_like'] = false;
        }

        return $this->attributes['is_like'] = Like::where('answer_id',$this->id)->where('user_id',auth()->id())->count() > 0;
    }

    public function like() {
        return $this->hasMany(Like::class,'answer_id','id');
    }

    public function comment() {
        return $this->hasMany(Comment::class,'answer_id','id');
    }

    public function emotion() {
        return $this->hasOne(Emotion::class,'id','emotion_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
