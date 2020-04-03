<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Professor
 *
 * @property integer $id
 * @property string $full_name
 * @property string $created_at
 * @property string $updated_at
 * @property Lesson[] $lessons
 * @property-read int|null $lessons_count
 * @method static Builder|Professor newModelQuery()
 * @method static Builder|Professor newQuery()
 * @method static Builder|Professor query()
 * @method static Builder|Professor whereCreatedAt($value)
 * @method static Builder|Professor whereFullName($value)
 * @method static Builder|Professor whereId($value)
 * @method static Builder|Professor whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Professor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'professors';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['full_name', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'auditories', 'created_at'];

    protected $casts = [
        'updated_at' => 'datetime:d-m-Y H:i:s'
    ];

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
        return $this->belongsToMany(Lesson::class, 'professor_lesson');
    }
}
