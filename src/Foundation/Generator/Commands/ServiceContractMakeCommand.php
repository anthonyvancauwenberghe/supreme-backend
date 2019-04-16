<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\ServiceContractGeneratedEvent;
use Symfony\Component\Console\Input\InputOption;

class ServiceContractMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:service-contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service contract for the specified service';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'service_contract';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'service-contract.stub';

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
    protected $event = ServiceContractGeneratedEvent::class;

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
            ['dto', null, InputOption::VALUE_OPTIONAL, 'A servicecontract with dto?', false],
        ];
    }

    protected function handleDtoOption($shortcut, $type, $question, $default)
    {
        return $this->confirm('Do you want dtos with the service contract?', $default);
    }

    protected function isDtoService()
    {
        return $this->getOption("dto");
    }

    protected function stubName()
    {
        if ($this->isDtoService())
            return "service-dto-contract.stub";
        return "service-contract.stub";
    }
}
