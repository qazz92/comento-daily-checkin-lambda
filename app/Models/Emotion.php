<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\DateFormat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Emotion
 *
 * @property int|null $id
 * @property string|null $emoji
 * @property int|null $value
 * @property string|null $name
 * @property string|null $answer
 * @property string|null $comment
 * @property string|null $uid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereEmoji($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Emotion whereValue($value)
 * @mixin \Eloquent
 */
class Emotion extends Model
{
    use DateFormat;

    protected $table = 'emotion';

	protected $casts = [
		'value' => 'int'
	];

	protected $fillable = [
		'emoji',
		'value',
		'name',
		'answer',
		'comment',
		'uid'
	];
}
