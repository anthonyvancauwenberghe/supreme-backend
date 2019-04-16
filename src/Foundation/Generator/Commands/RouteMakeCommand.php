<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\AbstractGeneratorCommand;
use Foundation\Generator\Abstracts\FileGeneratorCommand;
use Foundation\Generator\Events\RouteGeneratedEvent;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RouteMakeCommand extends FileGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new route file for the specified module';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'route';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'route.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Routes';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = RouteGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'MODULE_NAME' => ucfirst($this->getModuleName()),
            'CAPS_MODULE_NAME' => strtoupper($this->getModuleName()),
            'VERSION' => $this->getVersion()
        ];
    }

    protected function getVersion() :string {
        return $this->getOption('versioning');
    }

    protected function afterGeneration(): void
    {
        $this->info("Don't forget to add permissions to the Permission model!");
    }

    protected function handleVersioningOption($shortcut, $type, $question, $default){
        return $this->anticipate('What is the version of the route?',['v1','v2','v3','v4','v5'],$default);
    }

    protected function setOptions(): array
    {
        return [
            ['versioning', null, InputOption::VALUE_OPTIONAL, 'The route version', 'v1'],
        ];
    }

    protected function getFileName() :string
    {
        return strtolower(Str::plural($this->getModuleName())).'.'.$this->getVersion() . '.php';
    }

}
