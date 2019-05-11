<?php

namespace Modules\Supreme\Console;

use Foundation\Abstracts\Jobs\LockingJob;
use Modules\Supreme\Abstracts\DispatchLockedJobCommand;
use Modules\Supreme\Jobs\CacheLatestDropItemsJob;
use Modules\Supreme\Jobs\CacheSupremeStockJob;
use Symfony\Component\Console\Input\InputArgument;

class CacheSupremeCommunityLatestDroplistCommand extends DispatchLockedJobCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'supreme:droplist:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';


    protected function job() :LockingJob
    {
        return new CacheLatestDropItemsJob(!$this->inSync());
    }


}
