<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Pivots\ProfessorLesson
 *
 * @property int $professor_id
 * @property int $lesson_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\ProfessorLesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\ProfessorLesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\ProfessorLesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\ProfessorLesson whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pivots\ProfessorLesson whereProfessorId($value)
 * @mixin \Eloquent
 */
class ProfessorLesson extends Pivot
{

}
