<?php

namespace Modules\Supreme\Console;

use Foundation\Abstracts\Jobs\LockingJob;
use Modules\Supreme\Abstracts\DispatchLockedJobCommand;
use Modules\Supreme\Jobs\CacheSupremeStockJob;
use Symfony\Component\Console\Input\InputArgument;

class CacheSupremeStockCommand extends DispatchLockedJobCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'supreme:stock:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';


    protected function job() :LockingJob
    {
        return new CacheSupremeStockJob($this->argument('region'), !$this->inSync());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['region', InputArgument::OPTIONAL, 'The region of the parsing','EU'],
        ];
    }

}
