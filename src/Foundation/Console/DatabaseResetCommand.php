<?php

namespace Foundation\Console;

use Artisan;
use Illuminate\Console\Command;

/**
 * Class DatabaseResetCommand.
 */
class DatabaseResetCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'db:reset {--demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all tables/collections and reseed.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('migrate:refresh');
        Artisan::call('cache:clear');
        Artisan::call('migrate');
        Artisan::call('db:seed');

        if ($this->option('demo')) {
            Artisan::call('demo:seed');
        }

        $this->info('Database has been reset!');
    }
}
