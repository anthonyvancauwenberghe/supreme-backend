<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\RepositoryContractGeneratedEvent;
use Foundation\Generator\Events\ServiceContractGeneratedEvent;

class RepositoryContractMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:repository-contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository contract for the specified repository';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'repository_contract';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'repository-contract.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Contracts';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = RepositoryContractGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }
}
