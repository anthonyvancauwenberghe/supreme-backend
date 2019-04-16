<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 17:15.
 */

namespace Foundation\Generator\Abstracts;

use Foundation\Core\Larapi;
use Foundation\Core\Module;
use Foundation\Generator\Events\CommandGeneratedEvent;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

abstract class ClassGeneratorCommand extends AbstractGeneratorCommand
{

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function setArguments(): array
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the ' . $this->getGeneratorName() . '.']
        ];
    }

    protected function handleNameArgument()
    {
        return $this->anticipate('Specify the name of the ' . $this->getGeneratorName() . '.', [ucfirst($this->getModuleName()) . ucfirst($this->getGeneratorName())]);
    }

    /**
     * @return string
     */
    protected function getFileName(): string
    {
        return $this->getClassName() . '.php';
    }

    /**
     * Get class namespace.
     *
     *
     * @return string
     */
    public function getClassNamespace(): string
    {
        return $this->getModule()->getNamespace() . str_replace('/', '\\', $this->filePath);
    }

    protected function getClassName()
    {
        $className = $this->getArgument('name');
        if ($className === null) {
            $this->error('class name not specified');
            throw new \Exception('Name of ' . $this->getGeneratorName() . ' not set.');
        }
        return $className;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions(): array
    {
        return [];
    }
}
