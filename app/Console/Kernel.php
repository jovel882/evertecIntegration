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
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('payments:refresh_status')
            ->cron('*/' . config('config.minutes_verify_pay') . ' * * * *')
            ->withoutOverlapping()
            ->timezone('America/Bogota');
        $schedule->command('expired:orders')
            ->dailyAt(config('config.time_expired_orders'))
            ->withoutOverlapping()
            ->timezone('America/Bogota');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
