<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Group
 *
 * @property integer $id
 * @property string $title
 * @property int $course
 * @property boolean $evening
 * @property string $created_at
 * @property string $updated_at
 * @method static Builder|Group newModelQuery()
 * @method static Builder|Group newQuery()
 * @method static Builder|Group query()
 * @method static Builder|Group whereCourse($value)
 * @method static Builder|Group whereCreatedAt($value)
 * @method static Builder|Group whereEvening($value)
 * @method static Builder|Group whereId($value)
 * @method static Builder|Group whereTitle($value)
 * @method static Builder|Group whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lesson[] $lessons
 * @property-read int|null $lessons_count
 */
class Group extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'groups';


    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * @var array
     */
    protected $fillable = ['title', 'course', 'evening', 'created_at', 'updated_at'];

    protected $casts = [
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'evening' => 'boolean'
    ];

    protected $hidden = ['id', 'created_at'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Возвращает все пары группы
     *
     * @return HasMany
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'group_id', 'id');
    }

}
