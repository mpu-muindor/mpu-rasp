<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\Lesson;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ParseWebinarLinks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 180;

    /**
     * Получает расписание с ссылками на вебинар
     * и обновляет их в текущих данных
     *
     * @return void
     */
    public function handle(): void
    {
        $response = Http::get('https://rasp.dmami.ru/semester.json');

        if (!$response->successful() && mb_strtolower($response->header('Content-Type')) !== 'application/json; charset=utf-8') {
            $this->fail(new Exception('Failed get "https://rasp.dmami.ru/semester.json" content'));
        }
        $response = $response->json();

        if (!array_key_exists('contents', $response)) {
            $this->fail(new Exception('Response without "contents"'));
        }

        $content = $response['contents'];
        unset($response);

        foreach ($content as $group_raw) {
            $group = Group::whereTitle($group_raw['group']['title'])->first() ?: null;
            if ($group === null) {
                continue;
            }
            foreach ($group_raw['grid'] as $day_number => $day_lessons) {
                $day_number = [
                    'date' => is_numeric($day_number) ? null : $day_number,
                    'week_day' => is_numeric($day_number) ? $day_number : Carbon::parse($day_number)->dayOfWeek,
                ];
                foreach ($day_lessons as $lesson_number => $lessons) {
                    foreach ($lessons as $lesson) {
                        /** @var Lesson $new_lesson */
                        $new_lesson = Lesson::whereGroupId($group->id)
                            ->whereDayNumber($day_number['week_day'])
                            ->whereLessonNumber($lesson_number)
                            ->whereSubject($lesson['sbj'])
                            ->whereType($lesson['type'])
                            ->whereDateTo($lesson['dt'] ?? null)->first() ?: null;

                        if ($new_lesson === null) {
                            continue;
                        }
                        $new_lesson->update(['remote_access' => $lesson['wl']]);

                        if ($new_lesson->getDirty()) {
                            // todo Сообщить об изменениях в паре
                        }
                    }
                }
            }
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception): void
    {
        Log::error($exception->getMessage());
    }
}
