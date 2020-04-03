<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Auditory
 *
 * @property integer $id
 * @property string $title
 * @property string $color
 * @property string $created_at
 * @property string $updated_at
 * @property Lesson[] $lessons
 * @property-read int|null $lessons_count
 * @method static Builder|Auditory newModelQuery()
 * @method static Builder|Auditory newQuery()
 * @method static Builder|Auditory query()
 * @method static Builder|Auditory whereColor($value)
 * @method static Builder|Auditory whereCreatedAt($value)
 * @method static Builder|Auditory whereId($value)
 * @method static Builder|Auditory whereTitle($value)
 * @method static Builder|Auditory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Auditory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auditories';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['title', 'color'];

    /**
     * @var array
     */
    protected $hidden = ['id', 'created_at', 'updated_at', 'auditories'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return BelongsToMany
     */
    public function lessons()
    {
        return $this->belongsToMany('App\Models\Lesson');
    }
}
