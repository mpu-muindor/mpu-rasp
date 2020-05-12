<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Professor;
use App\Repositories\GroupRepository;
use App\Repositories\ProfessorRepository;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    /**
     * Возвращает расписание группы
     *
     * @param  Group  $group
     * @param  Request  $request
     * @param  GroupRepository  $groupRepository
     *
     * @return array
     */
    public function getGroupLessons(Group $group, Request $request, GroupRepository $groupRepository): array
    {
        $request->validate([
            'type' => 'string|in:list,grid',
            'available' => 'boolean'
        ]);
        ['type' => $type, 'available' => $available] = $request->all(['type', 'available']);
        $type = $type ?? 'list';
        $available = $available ?? false;

        if ($type === 'list') {
            if ($available) {
                $data = $groupRepository->getLessonsAvailableOnlyList($group);
            } else {
                $data = $groupRepository->getLessonsList($group);
            }
        } elseif ($type === 'grid') {
            if ($available) {
                $data = $groupRepository->getLessonsLikeGridAvailableOnlyList($group);
            } else {
                $data = $groupRepository->getLessonsLikeGridList($group);
            }
        } else {
            $data = $groupRepository->getLessonsList($group);
        }

        return array_values($data->toArray());
    }

    /**
     * Возвращает расписание преподавателя
     *
     * @param  Professor  $professor
     * @param  Request  $request
     * @param  ProfessorRepository  $professorRepository
     *
     * @return array
     */
    public function getProfessorLessons(
        Professor $professor,
        Request $request,
        ProfessorRepository $professorRepository
    ): array {
        ['type' => $type, 'available' => $available] = $request->all(['type', 'available']);
        $type = $type ?? 'list';
        $available = $available ?? false;

        if ($type === 'list') {
            if ($available) {
                $data = $professorRepository->getLessonsAvailableOnlyList($professor);
            } else {
                $data = $professorRepository->getLessonsList($professor);
            }
        } elseif ($type === 'grid') {
            if ($available) {
                $data = $professorRepository->getLessonsLikeGridAvailableOnlyList($professor);
            } else {
                $data = $professorRepository->getLessonsLikeGridList($professor);
            }
        } else {
            $data = $professorRepository->getLessonsList($professor);
        }

        return array_values($data->toArray());
    }

}
