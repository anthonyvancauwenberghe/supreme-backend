<?php

namespace Modules\Demo\Console;

use Illuminate\Console\Command;
use Modules\Demo\Jobs\SeedDemoDataJob;

class SeedDemoDataCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'demo:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Demo data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        dispatch(new SeedDemoDataJob());
        $this->info('Seed Demo data job triggered.');
    }
}
