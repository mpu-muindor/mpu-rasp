<?php

namespace App\Console;

use App\Jobs\UpdateGroupListJob;
use App\Jobs\UpdateScheduleJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new UpdateGroupListJob())->dailyAt(6)->timezone('Europe/Moscow');
        // Обновление расписания обычно происходит в ~7:00 и после 18 часов
        $schedule->job(new UpdateScheduleJob())->twiceDaily(8, 20)->timezone('Europe/Moscow');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
