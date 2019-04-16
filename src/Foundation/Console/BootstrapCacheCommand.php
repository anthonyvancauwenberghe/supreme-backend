<?php

namespace Foundation\Console;

use Foundation\Services\BootstrapRegistrarService;
use Illuminate\Console\Command;

class BootstrapCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'bootstrap:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recache the bootstrapping modules.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(BootstrapRegistrarService $service)
    {
        $service->recache();
        $this->info('Commands cached successfully.');
    }
}
