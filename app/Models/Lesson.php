<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Lesson
 *
 * @property integer $id
 * @property string $subject
 * @property string $date_from
 * @property string $date_to
 * @property string $type
 * @property int $day_number
 * @property int $lesson_number
 * @property string $lesson_day
 * @property boolean $is_session
 * @property string $remote_access
 * @property string $created_at
 * @property string $updated_at
 * @property Auditory[] $auditories
 * @property Professor[] $professors
 * @property-read int|null $auditories_count
 * @property-read int|null $professors_count
 * @method static Builder|Lesson newModelQuery()
 * @method static Builder|Lesson newQuery()
 * @method static Builder|Lesson query()
 * @method static Builder|Lesson whereCreatedAt($value)
 * @method static Builder|Lesson whereDateFrom($value)
 * @method static Builder|Lesson whereDateTo($value)
 * @method static Builder|Lesson whereDayNumber($value)
 * @method static Builder|Lesson whereId($value)
 * @method static Builder|Lesson whereIsSession($value)
 * @method static Builder|Lesson whereLessonDay($value)
 * @method static Builder|Lesson whereLessonNumber($value)
 * @method static Builder|Lesson whereRemoteAccess($value)
 * @method static Builder|Lesson whereSubject($value)
 * @method static Builder|Lesson whereType($value)
 * @method static Builder|Lesson whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $group_id
 * @property-read Group $group
 * @method static Builder|Lesson whereGroupId($value)
 */
class Lesson extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lessons';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * @var array
     */
    protected $fillable = [
        'subject',
        'date_from',
        'date_to',
        'type',
        'day_number',
        'lesson_number',
        'lesson_day',
        'is_session',
        'remote_access',
        'group_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_from' => 'datetime:Y-m-d',
        'updated_at' => 'datetime',
        'date_to' => 'datetime:Y-m-d',
        'lesson_day' => 'datetime',
        'is_session' => 'boolean'
    ];

    protected $dates = ['date_from', 'date_to', 'lesson_day'];

    protected $with = ['auditories', 'group', 'professors'];

    protected $hidden = ['id', 'group_id', 'created_at', 'pivot', 'remote_access'];

    protected $appends = ['status'];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['group', 'professor'];

    public function getStatusAttribute()
    {
        $now = Carbon::now()->hour(0)->minute(0)->second(0)->microsecond(0);
        return [
            'started' => $this->date_from <= $now,
            'finished' => $this->date_to < $now
        ];
    }

    /**
     * Группа, у которой пара
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    /**
     * Массив аудиторий пары
     *
     * @return BelongsToMany
     */
    public function auditories(): BelongsToMany
    {
        return $this->belongsToMany(Auditory::class,
            'auditory_lesson')->using(Pivots\AuditoryLesson::class)->as('auditories');
    }

    /**
     * Массив преподавателей пары
     *
     * @return BelongsToMany
     */
    public function professors(): BelongsToMany
    {
        return $this->belongsToMany(Professor::class, 'professor_lesson')
            ->using(Pivots\ProfessorLesson::class)
            ->as('auditories');
    }
}
