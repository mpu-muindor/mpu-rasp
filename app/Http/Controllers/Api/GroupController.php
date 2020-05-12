<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Возвращает список всех групп
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Group::orderBy('title')->get();
    }

    /**
     * Возвращает группу
     *
     * @param  Group  $group
     *
     * @return Group
     */
    public function show(Group $group): Group
    {
        return $group;
    }
}
