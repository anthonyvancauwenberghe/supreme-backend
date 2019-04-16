<?php

namespace Foundation\Generator\Commands;

use Foundation\Core\Larapi;
use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\RepositoryGeneratedEvent;
use Foundation\Generator\Managers\GeneratorManager;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class for the specified model';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'repository';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'repository.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Repositories';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = RepositoryGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
            'MODEL' => $this->getModelName(),
            'MODEL_NAMESPACE' => $this->getModelNameSpace(),

        ];
    }

    public function afterGeneration(): void
    {
        GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
            ->createRepositoryContract(ucfirst($this->getClassName()) . 'Contract');

        $this->info('Do not forget to register the repository contract in your service provider!');
    }

    protected function getModelName()
    {
        return ucfirst($this->getOption('model'));
    }

    protected function getModelNamespace()
    {
        return "Modules\\".$this->getModuleName()."\\Entities\\".$this->getModelName();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions(): array
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The name of the model.', null],
        ];
    }

    protected function handleModelOption($shortcut, $type, $question, $default){
        return $this->anticipate('What is the name of the model?', Larapi::getModule($this->getModuleName())->getModels()->getAllPhpFileNamesWithoutExtension());
    }
}
