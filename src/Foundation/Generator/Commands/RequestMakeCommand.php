<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\RequestGeneratedEvent;

class RequestMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'request';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'request.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Http/Requests';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = RequestGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }
}
