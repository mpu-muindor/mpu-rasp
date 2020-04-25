<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

class GroupApiController extends Controller
{
    /**
     * Возвращает список всех групп
     *
     * @return \Illuminate\Support\Collection
     */
    public function index(): \Illuminate\Support\Collection
    {
        return Group::orderBy('title')->get();
    }

    /**
     * Возвращает группу
     *
     * @param  Group  $group
     * @return Group
     */
    public function show(Group $group): Group
    {
        return $group;
    }

    /**
     * Возвращает расписание группы
     *
     * @param  Group  $group
     * @return Collection
     */
    public function getLessons(Group $group): Collection
    {
        return $group->lessons()->orderBy('day_number')->orderBy('lesson_number')->orderBy('date_from')->get();
    }
}
