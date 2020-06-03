<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\Group as Model;
use Illuminate\Support\Collection;

/**
 * Class GroupRepository
 *
 * @package App\Repositories
 */
class GroupRepository extends CoreRepository
{
    /**
     * Возвращает расписание группы с группировкой
     * занятий по дням недели и номеру пары
     *
     * @param  Group  $group
     *
     * @return Collection
     */
    public function getLessonsLikeGridList(Group $group): Collection
    {
        return $this->getLessonsList($group)
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
     * @param  Group  $group
     *
     * @return Collection
     */
    public function getLessonsList(Group $group): Collection
    {
        return new Collection($group->lessons()
            ->orderBy('day_number')
            ->orderBy('lesson_number')
            ->orderBy('date_to')
            ->without('group')
            ->get());
    }

    /**
     * Возвращает только текущие занятия группы с группировкой
     * занятий по дням недели и номеру пары
     *
     * @param  Group  $group
     *
     * @return Collection
     */
    public function getLessonsLikeGridAvailableOnlyList(Group $group): Collection
    {
        return $this->getLessonsAvailableOnlyList($group)
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
     * @param  Group  $group
     *
     * @return Collection
     */
    public function getLessonsAvailableOnlyList(Group $group): Collection
    {
        return new Collection($this->getLessonsList($group)
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
