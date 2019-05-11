<?php


namespace Modules\Supreme\Jobs;

use Cache;
use Foundation\Abstracts\Jobs\Job;
use Foundation\Abstracts\Jobs\LockingJob;
use Modules\Supreme\Parsers\SupremeStockParser;
use Throwable;

class CacheSupremeStockJob extends LockingJob
{
    protected $region;

    /**
     * CacheSupremeItemsJob constructor.
     * @param string $region
     * @param bool $requeue
     */
    public function __construct(string $region, bool $requeue = false)
    {
        parent::__construct($requeue);
        $this->region = $region;
    }

    public function execute()
    {
        (new SupremeStockParser($this->region))->parse();
    }

    public function lockName(): ?string
    {
        return 'supreme:' . $this->region;
    }

}
