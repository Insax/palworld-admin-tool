<?php

namespace App\Console;

use App\Jobs\SyncPlayers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Short Schedule to get the job time down to 5 seconds.
     *
     * @param \Spatie\ShortSchedule\ShortSchedule $shortSchedule
     * @return void
     */
    protected function shortSchedule(\Spatie\ShortSchedule\ShortSchedule $shortSchedule): void
    {
        // this command will run every second
        $shortSchedule->command('pal:sync')->everySeconds(5);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
