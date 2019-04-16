<?php

namespace Foundation\Console;

use Illuminate\Console\Command;

class DisplayEnvCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'env:display';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Outputs the env file';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info(file_get_contents(base_path('.env')));
    }
}
