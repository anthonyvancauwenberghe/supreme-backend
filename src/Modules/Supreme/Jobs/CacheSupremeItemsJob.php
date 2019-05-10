<?php


namespace Modules\Supreme\Jobs;

use Cache;
use Foundation\Abstracts\Jobs\Job;
use Modules\Supreme\Parsers\SupremeStockParser;
use Throwable;

class CacheSupremeItemsJob extends Job
{
    protected $region;

    protected $requeue;

    /**
     * CacheSupremeItemsJob constructor.
     * @param string $region
     * @param bool $requeue
     */
    public function __construct(string $region, bool $requeue = false)
    {
        $this->region = $region;
        $this->requeue = $requeue;
    }

    public function handle()
    {
        $lock = Cache::lock("supremeparsing:$this->region", 60);

        if ($lock->get()) {
            try {
                (new SupremeStockParser($this->region))->parse();
                $lock->forceRelease();
            } catch (Throwable $exception) {
                $lock->forceRelease();
                if ($this->shouldRequeue())
                    dispatch(new CacheSupremeItemsJob($this->region))->delay(30);
                throw $exception;
            }
            if ($this->shouldRequeue())
                dispatch(new CacheSupremeItemsJob($this->region));
        }
    }

    protected function shouldRequeue(){
        return $this->requeue && $this->connection !== null && $this->connection !== 'sync';
    }

}