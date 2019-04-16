<?php

namespace Foundation\Generator\Commands;

use Foundation\Core\Larapi;
use Foundation\Generator\Generators\DefaultModuleGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ModuleMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = ucfirst(strtolower($this->argument('name')));

        $this->handleExistingModule($moduleName);

        $generator = new DefaultModuleGenerator($moduleName);
        $generator->generate();
    }

    protected function handleExistingModule($moduleName)
    {
        if (Larapi::getModule($moduleName)->exists()) {
            $this->error('Module already exists. Please delete it first.');
            exit();
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the module that will be created.'],
        ];
    }
}
