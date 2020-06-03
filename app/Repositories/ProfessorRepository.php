<?php

namespace App\Repositories;

use App\Models\Professor;
use App\Models\Professor as Model;
use Illuminate\Support\Collection;

/**
 * Class ProfessorRepository
 *
 * @package App\Repositories
 */
class ProfessorRepository extends CoreRepository
{
    /**
     * Возвращает расписание группы с группировкой
     * занятий по дням недели и номеру пары
     *
     * @param  Model  $professor
     *
     * @return Collection
     */
    public function getLessonsLikeGridList(Professor $professor): Collection
    {
        return $this->getLessonsList($professor)
            ->groupBy([
                'day_number',
                static function ($item) {
                    return $item['lesson_number'];
                }
            ]);
    }

    /**
     * Возвращает расписание группы
     *
     * @param  Model  $professor
     *
     * @return Collection
     */
    public function getLessonsList(Professor $professor): Collection
    {
        return new Collection($professor->lessons()
            ->orderBy('day_number')
            ->orderBy('lesson_number')
            ->orderBy('date_to')
            ->get());
    }

    /**
     * Возвращает только текущие занятия группы с группировкой
     * занятий по дням недели и номеру пары
     *
     * @param  Model  $professor
     *
     * @return Collection
     */
    public function getLessonsLikeGridAvailableOnlyList(Professor $professor): Collection
    {
        return $this->getLessonsAvailableOnlyList($professor)
            ->groupBy([
                'day_number',
                static function ($item) {
                    return $item['lesson_number'];
                }
            ]);
    }

    /**
     * Возвращает текущие занятия группы
     *
     * @param  Model  $professor
     *
     * @return Collection
     */
    public function getLessonsAvailableOnlyList(Professor $professor): Collection
    {
        return new Collection($this->getLessonsList($professor)
            ->where('status.finished', '=', false));
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
