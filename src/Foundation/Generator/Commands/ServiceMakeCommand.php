<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\ServiceGeneratedEvent;
use Foundation\Generator\Managers\GeneratorManager;
use Symfony\Component\Console\Input\InputOption;

class ServiceMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class for the specified module';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'service';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Services';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = ServiceGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }

    public function afterGeneration(): void
    {
        if(!$this->isDtoService()){
            GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
                ->createServiceContract(ucfirst($this->getClassName()) . 'Contract');
        }
        else{
            GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
                ->createServiceContract(ucfirst($this->getClassName()) . 'Contract',true);
            GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
                ->createDto('Create' . $this->getCleanName() . 'Data');

            GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
                ->createDto('Update' . $this->getCleanName() . 'Data');
        }
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
        return $this->confirm('Do you want dtos with the service?', $default);
    }

    protected function isDtoService()
    {
        return $this->getOption("dto");
    }

    protected function stubName()
    {
        if ($this->isDtoService())
            return "service-dto.stub";
        return "service.stub";
    }
}
