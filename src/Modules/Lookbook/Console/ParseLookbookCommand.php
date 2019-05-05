<?php

namespace Modules\Lookbook\Console;

use Illuminate\Console\Command;
use Modules\Lookbook\Entities\SpringSummer2019Lookbook;
use Modules\Lookbook\Jobs\SpringSummer2019LookbookParserJob;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ParseLookbookCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lookbook:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the lookbook from the supreme site and export it to a json.';

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
     * @return mixed
     */
    public function handle()
    {
        $job = new SpringSummer2019LookbookParserJob();
        $job->getModel()::truncate();
        $this->info('truncated old models starting parsing now');
        dispatch_now($job);
    }
}
