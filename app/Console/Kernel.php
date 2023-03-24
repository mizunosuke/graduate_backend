<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // 毎週月曜日の0時にランキングを集計
        $schedule->command('ranking:calculate')->weekly()->mondays()->at('0:00');
        // $schedule->command('ranking:calculate')->cron('* * * * *');

        // 毎週月曜日の1時に新しい期間のランキングを作成
        $schedule->command('ranking:create')->weekly()->mondays()->at('1:00');
        // $schedule->command('ranking:create')->cron('* * * * *');
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
