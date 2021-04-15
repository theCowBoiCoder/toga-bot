<?php

namespace App\Console;

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
        $schedule->command('togabot:its_night_watchman_time')->twiceDaily(23,6)->evenInMaintenanceMode()->onOneServer();
        $schedule->command('togabot:get_match_by_match_day')->twiceDaily(9,22)->evenInMaintenanceMode()->onOneServer();
        $schedule->command('togabot:store_team_data')->dailyAt('23:00')->evenInMaintenanceMode()->onOneServer();
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
