<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Database\Eloquent\Collection;

class ProfessorApiController extends Controller
{
    /**
     * Возвращает всех преподавателей в системе
     *
     * @return \Illuminate\Support\Collection
     */
    public function index(): \Illuminate\Support\Collection
    {
        return Professor::orderBy('full_name')->get();
    }

    /**
     * Возвращает преподавателя
     *
     * @param  Professor  $professor
     * @return Professor
     */
    public function show(Professor $professor): Professor
    {
        return $professor;
    }

    /**
     * Возвращает пары преподавателя
     *
     * @param  Professor  $professor
     * @return Collection
     */
    public function getLessons(Professor $professor): Collection
    {
        return $professor->lessons()->get();
    }

}
