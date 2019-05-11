<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.05.19
 * Time: 14:48
 */

namespace Modules\Supreme\Abstracts;


use Foundation\Abstracts\Jobs\LockingJob;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class DispatchLockedJobCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $job = $this->job();

        if(($lock =$job->getLock())->get()){
            $lock->forceRelease();
            if ($this->inSync()) {
                $this->info('parsing started');

                $time_start = microtime(true);
                dispatch_now($this->job());
                $this->info('done parsing');

                $this->info("Finished. Parsing Took " . round((microtime(true) - $time_start), 2) . "seconds");
            } else {
                dispatch($this->job());
                $this->info('Job dispatched');
            }
        }
        else{
            $this->info('Job is already in queue');
        }
    }

    protected abstract function job() :LockingJob;

    protected function getOptions()
    {
        return [
            ['sync', null, InputOption::VALUE_NONE, 'Should the job be executed in sync?'],
        ];
    }

    protected function inSync()
    {
        return $this->option('sync');
    }
}
