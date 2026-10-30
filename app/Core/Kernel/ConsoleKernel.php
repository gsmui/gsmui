<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as BaseConsoleKernel;

class ConsoleKernel extends BaseConsoleKernel
{
    /**
     * The Artisan commands provided by the application.
     *
     * @var array<int, class-string|string>
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/../Console/Commands');

        require base_path('routes/console.php');
    }
}
