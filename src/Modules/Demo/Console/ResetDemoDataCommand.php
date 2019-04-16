<?php

namespace Modules\Demo\Console;

use Illuminate\Console\Command;

class ResetDemoDataCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

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
        $this->call('db:reset');
        $this->call('demo:seed');
        $this->call('demo:alter');
        $this->info('Seed Demo data job triggered.');
    }
}
