<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\EventGeneratedEvent;

class EventMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event class for the specified module';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'event';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'event.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Events';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = EventGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }
}
