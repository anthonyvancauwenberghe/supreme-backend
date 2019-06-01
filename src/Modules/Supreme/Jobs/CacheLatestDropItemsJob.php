<?php


namespace Modules\Supreme\Jobs;

use Cache;
use Foundation\Abstracts\Jobs\Job;
use Foundation\Abstracts\Jobs\LockingJob;
use Modules\Supreme\Cache\SupremeDropListCache;
use Modules\Supreme\Parsers\SupremeStockParser;
use Supreme\Parser\SupremeCommunityLatestDroplistParser;
use Throwable;

class CacheLatestDropItemsJob extends LockingJob
{
    protected $requeueDelay = 24 * 3600;

    public function execute()
    {
        $parser = new SupremeCommunityLatestDroplistParser(2, true);
        $items = $parser->parse();

        if ($items !== null && !empty($items))
            SupremeDropListCache::put($items);
    }
}
