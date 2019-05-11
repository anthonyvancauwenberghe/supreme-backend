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
use Modules\Supreme\Console\CacheSupremeCommunityLatestDroplistCommand;
use Modules\Supreme\Console\CacheSupremeStockCommand;
use Modules\Supreme\Jobs\CacheLatestDropItemsJob;
use Modules\Supreme\Jobs\CacheSupremeStockJob;
use Modules\Supreme\Jobs\SupremeIncomingDropCheckJob;

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
        $schedule->command('supreme:stock:cache',['region' => 'EU'])->everyMinute();
       // $schedule->command(new CacheSupremeStockCommand(),['region' => 'JAPAN'])->everyMinute();
       // $schedule->command(new CacheSupremeStockCommand(),['region' => 'AMERICA'])->everyMinute();
        $schedule->command('supreme:droplist:cache')->everyMinute();
        //$schedule->job(new SupremeIncomingDropCheckJob())->everyMinute();
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
