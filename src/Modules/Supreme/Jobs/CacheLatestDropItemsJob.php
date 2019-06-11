<?php


namespace Modules\Supreme\Jobs;

use Foundation\Abstracts\Jobs\LockingJob;
use Modules\Supreme\Cache\SupremeDropListCache;
use Supreme\Parser\SupremeCommunity;
use Throwable;

class CacheLatestDropItemsJob extends LockingJob
{
    protected $requeueDelay = 1 * 3600;

    public function execute()
    {
        try {
            $supremeCommunity = new SupremeCommunity(3, true);
            $items = $supremeCommunity->getLatestDroplistItems();

            if ($items !== null && !empty($items))
                SupremeDropListCache::put($items);

        } catch (Throwable $e) {

        }
    }
}
