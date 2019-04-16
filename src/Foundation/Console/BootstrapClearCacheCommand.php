<?php

namespace Foundation\Console;

use Foundation\Services\BootstrapRegistrarService;
use Illuminate\Console\Command;

class BootstrapClearCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'bootstrap:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the bootstrapping cache.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(BootstrapRegistrarService $service)
    {
        $service->clearCache();
        $this->info('Bootstrap cache cleared!');
    }
}
