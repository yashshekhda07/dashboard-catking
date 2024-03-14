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
        Commands\ozonetel::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $file = 'cron:ozonetel.log';
        $schedule->command('command:ozonetel')->cron('*/15 * * * *')->appendOutputTo(storage_path('logs/' . $file));
        $file2 = 'cron:ozonetel_2.log';
        $schedule->command('command:ozonetel_2')->cron('0 8 * * *')->appendOutputTo(storage_path('logs/' . $file2));

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
