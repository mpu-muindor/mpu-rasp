<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Professor;
use Illuminate\Http\Request;

class RaspApiController extends Controller
{
    /**
     * Возвращает подсказки для поиска
     *
     * @param  Request  $request
     * @return array
     */
    public function getSuggest(Request $request): array
    {
        $request->validate(['suggest' => 'required|string|min:2']);

        $suggest = $request->get('suggest');

        // TODO: Перенести запросы и обработку в репозиторий

        $groups = Group::where('title', 'like', $suggest.'%')->orderBy('title')->limit(3)->get(['title']);
        $professors = Professor::where('full_name', 'like', $suggest.'%')
            ->orderBy('full_name')
            ->limit(3)
            ->get(['full_name']);
        $groups->map(static function (Group $group) use ($suggest) {
            $group->setAttribute('completion', substr_replace($group->title, '', 0, strlen($suggest)));
        });
        $professors->map(static function (Professor $professor) use ($suggest) {
            $professor->setAttribute('completion', substr_replace($professor->full_name, '', 0, strlen($suggest)));
        });
        $params = [
            'suggest' => $suggest,
            'total' => [
                'groups' => Group::where('title', 'like', $suggest.'%')->count(),
                'professors' => Professor::where('full_name', 'like', $suggest.'%')->count()
            ]
        ];

        return ['groups' => $groups, 'professors' => $professors, 'params' => $params];
    }
}
