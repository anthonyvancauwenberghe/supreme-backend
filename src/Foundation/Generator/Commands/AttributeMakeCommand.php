<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\AttributeGeneratedEvent;
use Foundation\Generator\Events\EventGeneratedEvent;
use Foundation\Generator\Events\ServiceGeneratedEvent;
use Foundation\Generator\Managers\GeneratorManager;

class AttributeMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:attribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new attribute interface for a model';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'attribute';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'attribute.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Attributes';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = AttributeGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }

    protected function afterGeneration(): void
    {
        $this->info("don't forget to implement this attribute on the model");
    }
}
