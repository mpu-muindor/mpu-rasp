<?php

namespace App\Jobs;

use App\Models\Group;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class UpdateGroupListJob
 * Обновляет список групп в БД
 *
 * @package App\Jobs
 * @author Egor `Muindor` Fadeev
 * @version 1.0
 */
class UpdateGroupListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The maximum number of exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 1;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * Обновляет список групп в БД
     *
     * @return void
     */
    public function handle(): void
    {
        $response = Http::get('http://rasp.dmami.ru/groups-list.json');

        if ($response->successful() && $response->header('Content-Type') === 'application/json; charset=utf-8' && array_key_exists('groups',
                $response->json())) {
            $groups = array();
            foreach ($response->json()['groups'] as $group_title) {
                $groups[] = new Group(['title' => $group_title]);
            }
            $groups = new Collection($groups);
            $groups = $groups->diff(Group::all('title'));

            foreach ($groups as $group) {
                $group->save();
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
        $msg = $exception->getMessage();
        Log::error('[ERROR] Get list of groups failed!');
        Log::error($msg);
    }
}
