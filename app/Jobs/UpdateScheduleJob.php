<?php

namespace App\Jobs;

use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class UpdateScheduleJob
 * Отправляет в очередь обновления расписание всех групп
 *
 * @package App\Jobs
 * @author Egor `Muindor` Fadeev
 * @version 1.0
 */
class UpdateScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     *
     * @return void
     */
    public function handle(): void
    {
        $groups = Group::all();
        foreach ($groups as $group) {
            UpdateGroupRaspJob::dispatch($group, false);
            UpdateGroupRaspJob::dispatch($group, true);
        }
    }
}
