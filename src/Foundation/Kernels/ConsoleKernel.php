<?php

namespace Foundation\Kernels;

use Foundation\Console\BootstrapCacheCommand;
use Foundation\Console\BootstrapClearCacheCommand;
use Foundation\Console\ClearModelsCacheCommand;
use Foundation\Console\DatabaseResetCommand;
use Foundation\Console\DisplayEnvCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as LaravelConsoleKernel;
use Modules\Demo\Jobs\AlterDemoDataJob;

class ConsoleKernel extends LaravelConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BootstrapCacheCommand::class,
        BootstrapClearCacheCommand::class,
        DatabaseResetCommand::class,
        ClearModelsCacheCommand::class,
        DisplayEnvCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->job(new AlterDemoDataJob())->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('src/Foundation/Routes/console.php');
    }
}
