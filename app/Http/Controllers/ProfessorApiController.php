<?php

namespace App\Http\Controllers;

use App\Models\Professor;

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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLessons (Professor $professor): \Illuminate\Database\Eloquent\Collection
    {
        return $professor->lessons()->get();
    }

}