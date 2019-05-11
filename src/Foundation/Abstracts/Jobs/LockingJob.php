<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.05.19
 * Time: 13:13
 */

namespace Foundation\Abstracts\Jobs;

use Cache;
use Illuminate\Contracts\Cache\Lock;
use Throwable;

abstract class LockingJob extends Job
{
    protected $requeue;

    protected $requeueDelay = 300;

    /**
     * CacheSupremeItemsJob constructor.
     * @param bool $requeue
     */
    public function __construct(bool $requeue = false)
    {
        $this->requeue = $requeue;
    }

    public function handle()
    {
        $lock = $this->getLock();

        if ($lock->get()) {
            try {
                $this->execute();
            } catch (Throwable $exception) {
                $this->handleException($lock, $exception);
            }
            if ($this->shouldRequeue())
                $this->reDispatch();
        }
    }

    protected abstract function execute();

    protected function handleException(Lock $lock, Throwable $exception)
    {
        if ($this->shouldRequeue())
            $this->reDispatch();
        throw $exception;
    }

    protected function shouldRequeue() :bool
    {
        return $this->requeue && $this->connection !== null && $this->connection !== 'sync';
    }

    protected function reDispatch() :void
    {
        dispatch(new static($this->region, $this->requeue))->delay($this->requeueDelay);
    }

    public function getLock(): Lock
    {
        return Cache::lock(static::class . $this->buildLockName(), $this->requeueDelay);
    }

    private function buildLockName() :string
    {
        if ($this->lockName() === null)
            $arguments = "";
        else
            $arguments = ":" . $this->lockName();
        return $arguments;
    }

    protected function lockName(): ?string
    {
        return null;
    }
}
