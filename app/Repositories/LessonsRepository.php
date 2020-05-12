<?php

namespace App\Repositories;

use App\Models\Lesson as Model;
use Illuminate\Support\Collection;

/**
 * Class LessonsRepository
 *
 * @package App\Repositories
 */
class LessonsRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
