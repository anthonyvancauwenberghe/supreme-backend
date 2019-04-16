<?php

namespace Modules\User\Console;

use Illuminate\Console\Command;

class ATestCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'atest:cmd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('working');
    }
}
