<?php

namespace Modules\Supreme\Console;

use Illuminate\Console\Command;
use Modules\Supreme\Jobs\CacheSupremeItemsJob;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ParseSupremeItemsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'supreme:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('parsing started');
        //place this before any script you want to calculate time
        $time_start = microtime(true);

        dispatch_now(new CacheSupremeItemsJob($this->argument('region'), false));

        $this->info('done parsing');

        $this->info("Finished. Parsing Took ".round((microtime(true) - $time_start),2). "seconds");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['region', InputArgument::REQUIRED, 'The region of the parsing'],
        ];
    }

}
