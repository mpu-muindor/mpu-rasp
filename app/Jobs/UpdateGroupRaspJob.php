<?php

namespace App\Jobs;

use App\Models\Auditory;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Professor;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Log;

class UpdateGroupRaspJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var bool
     */
    private $session;

    /**
     * @var Group
     */
    private $group;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @param  Group  $group
     * @param  bool  $session
     */
    public function __construct(Group $group, bool $session)
    {
        $this->group = $group;
        $this->session = $session;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $group = $this->group->title;
        $session = $this->session;
        $response = Http::withHeaders(['referer' => 'https://rasp.dmami.ru/'])
            ->get('https://rasp.dmami.ru/site/group', ['session' => $session, 'group' => $group]);

        if ($response->successful() && mb_strtolower($response->header('Content-Type')) === 'application/json; charset=utf-8') {
            $response = $response->json();
            $is_session = $response['isSession'];
            if (array_key_exists('group', $response)) {
                $this->group->update([
                    'course' => $response['group']['course'],
                    'evening' => $response['group']['evening']
                ]);
            }
            if (array_key_exists('grid', $response)) {
                foreach ($response['grid'] as $day_number => $day_lessons) {
                    $day_number = [
                        'date' => is_numeric($day_number) ? null : $day_number,
                        'week_day' => is_numeric($day_number) ? $day_number : Carbon::parse($day_number)->dayOfWeek,
                    ];
                    foreach ($day_lessons as $lesson_number => $lessons) {
                        foreach ($lessons as $lesson) {
                            $new_lesson = Lesson::whereGroupId($this->group->id)
                                ->whereDayNumber($day_number['week_day'])
                                ->whereLessonNumber($lesson_number)
                                ->whereSubject($lesson['sbj'])
                                ->whereType($lesson['type'])
                                ->whereDateTo($lesson['dt'] ?? null)->first() ?: new Lesson();

                            $new_lesson->day_number = $day_number['week_day'];
                            $new_lesson->lesson_number = $lesson_number;
                            $new_lesson->subject = $lesson['sbj'];
                            $new_lesson->type = $lesson['type'];
                            $new_lesson->group_id = $this->group->id;
                            $new_lesson->is_session = $is_session;

                            $new_lesson->lesson_day = $day_number['date'];
                            $new_lesson->date_to = $lesson['dt'] ?? null;
                            $new_lesson->date_from = $lesson['df'] ?? null;

                            $new_lesson->save();
                            foreach ($lesson['auditories'] as $auditory) {
                                preg_match('/^<a.*?href=(["\']|["\'\\\\])(.*?)\1.*$/', $auditory['title'], $remote);
                                if (count($remote) === 3) {
                                    $new_lesson->remote_access = $remote[2];
                                }
                                $title = strip_tags($auditory['title']);
                                $auditory = Auditory::whereTitle($title)->first() ?:
                                    new Auditory(['title' => $title, 'color' => $auditory['color'] ?? null]);
                                $auditory->save();
                                $new_lesson->auditories()->syncWithoutDetaching([$auditory->id]);
                            }
                            foreach (explode(', ', $lesson['teacher']) as $professor) {
                                $professor = Professor::whereFullName($professor)->first() ?:
                                    new Professor(['full_name' => $professor]);
                                $professor->save();
                                $new_lesson->professors()->syncWithoutDetaching([$professor->id]);
                            }
                            $new_lesson->update();
                        }
                    }

                }
            } else {
                $this->fail(new Exception('Dont exists "grid" in response'));
                return;
            }
            return;
        }
        $this->fail(new Exception($response->body()));
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception): void
    {
        $group = $this->group->title;
        $msg = $exception->getMessage();
        if ($msg !== 'Еще не готово расписание для группы') {
            Log::error("[ERROR] Get list of lessons group \"$group\" failed!");
            Log::error($exception->getMessage());
        } else {
            Log::alert("[ALERT] Group schedule \"$group\" not ready.");
            $this->delay(3600);
        }
    }
}
