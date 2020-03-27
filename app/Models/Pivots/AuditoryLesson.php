<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Pivots\AuditoryLesson
 *
 * @property int $auditory_id
 * @property int $lesson_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\AuditoryLesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\AuditoryLesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\AuditoryLesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\AuditoryLesson whereAuditoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\AuditoryLesson whereLessonId($value)
 * @mixin \Eloquent
 */
class AuditoryLesson extends Pivot
{

}
