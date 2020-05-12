<?php

namespace App\Http\Controllers\Api;

use App\Models\Professor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ProfessorController extends Controller
{
    /**
     * Возвращает всех преподавателей в системе
     *
     * @return Collection
     */
    public function index(): Collection
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
}
