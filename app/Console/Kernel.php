<?php

namespace App\Console;

use App\Console\Commands\BestchangeObserverCommand;
use App\Console\Commands\HealthcheckCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(HealthcheckCommand::class)->everyMinute()->withoutOverlapping(10);
        $schedule->command(HealthcheckCommand::class)->everyMinute()->withoutOverlapping(10);
        $schedule->command(BestchangeObserverCommand::class)->everyMinute()->withoutOverlapping(10);
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
