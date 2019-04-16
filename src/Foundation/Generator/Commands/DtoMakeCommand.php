<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\AttributeGeneratedEvent;
use Foundation\Generator\Events\DtoGeneratedEvent;
use Foundation\Generator\Events\EventGeneratedEvent;
use Foundation\Generator\Events\ServiceGeneratedEvent;
use Foundation\Generator\Managers\GeneratorManager;

class DtoMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:dto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new data transfer object';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'dto';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'dto.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Dtos';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = DtoGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }
}
