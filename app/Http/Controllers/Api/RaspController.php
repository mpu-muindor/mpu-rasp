<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use App\Models\Professor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RaspController extends Controller
{
    /**
     * Возвращает подсказки для поиска
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function getSuggest(Request $request): array
    {
        $request->validate([
            'suggest' => 'required|string|min:2',
            'limit' => 'integer|min:1|max:32',
            'offset' => 'integer|min:1'
        ]);

        $suggest = $request->get('suggest');
        $limit = $request->get('limit') ?? 5;
        $offset = $request->get('offset') ?? 0;

        // TODO: Перенести запросы и обработку в репозиторий

        $groups = Group::where('title', 'like', $suggest.'%')
            ->orderBy('title')
            ->offset($offset)
            ->limit($limit)
            ->get(['title']);
        $professors = Professor::where('full_name', 'like', $suggest.'%')
            ->orderBy('full_name')
            ->offset($offset)
            ->limit($limit)
            ->get(['full_name']);
        $groups->map(static function (Group $group) use ($suggest) {
            $group->setAttribute('completion', substr_replace($group->title, '', 0, strlen($suggest)));
        });
        $professors->map(static function (Professor $professor) use ($suggest) {
            $professor->setAttribute('completion', substr_replace($professor->full_name, '', 0, strlen($suggest)));
        });
        $params = [
            'suggest' => $suggest,
            'offset' => $offset,
            'limit' => $limit,
            'total' => [
                'groups' => Group::where('title', 'like', $suggest.'%')->count(),
                'professors' => Professor::where('full_name', 'like', $suggest.'%')->count()
            ]
        ];

        return ['groups' => $groups, 'professors' => $professors, 'params' => $params];
    }

    public function getSearch(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:3',
            'type' => 'string|in:group,professor'
        ]);
        ['query' => $query, 'type' => $type] = $request->all(['query', 'type']);
        $type = $type ?? 'professor';

        if ($type === 'professor') {
            $professors = Professor::where('full_name', 'like', "%$query%")
                ->orderBy('full_name')
                ->get('full_name');
            $professors = $professors->toArray();

            return array_values($professors);
        }

        $group = Group::where('title', 'like', "%$query%")
            ->orderBy('title')
            ->get('title');
        $group = $group->toArray();

        return array_values($group);
    }
}
