<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\ControllerGeneratedEvent;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful controller for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'controller';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'controller.stub';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = ControllerGeneratedEvent::class;

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Http/Controllers';

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions(): array
    {
        return [
            ['dto', null, InputOption::VALUE_OPTIONAL, 'A service with dto?', false],
        ];
    }

    protected function handleDtoOption($shortcut, $type, $question, $default)
    {
        return $this->confirm('Do you want dtos with this controller?', $default);
    }

    protected function hasDtoOption()
    {
        return $this->getOption("dto");
    }

    protected function stubName()
    {
        if ($this->hasDtoOption())
            return "controller-dto.stub";
        return "controller.stub";
    }
}
