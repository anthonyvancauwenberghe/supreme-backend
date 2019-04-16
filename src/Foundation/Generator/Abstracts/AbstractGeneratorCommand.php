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
use Foundation\Exceptions\Exception;
use Foundation\Generator\Support\Stub;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractGeneratorCommand extends Command
{
    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName;

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub;

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event;


    /**
     * The data that is inputted from the options.
     *
     * @var array
     */
    protected $optionData = [];

    /**
     * The data that is inputted from the arguments.
     *
     * @var array
     */
    protected $argumentData = [];

    public function handle()
    {
        $this->handleArguments();
        $this->handleOptions();

        $path = $this->getFilteredPath();

        if (file_exists($path) && !$this->isOverwriteable()) {
            $this->error("File : {$path} already exists.");
            throw new FileExistsException();
        }

        $stub = new Stub($this->stubName(), array_merge($this->defaultStubOptions(), $this->stubOptions()));

        $this->beforeGeneration();

        if ($this->event === null)
            throw new Exception("No Generator event specified on " . static::class);

        event(new $this->event($path, $stub));
        $this->info("Created : {$path}");

        $this->afterGeneration();
    }

    private function getFilteredPath(): string
    {
        return str_replace('\\', '/', $this->getDestinationFilePath());
    }

    /**
     * @return string
     */
    protected function getDestinationFilePath(): string
    {
        return $this->getModule()->getPath() . $this->filePath . '/' . $this->getFileName();
    }

    /**
     * @return string
     */
    protected abstract function getFileName(): string;

    protected function isOverwriteable(): bool
    {
        return $this->getOption('overwrite');
    }

    protected function getModule(): Module
    {
        return Larapi::getModule($this->getModuleName());
    }

    protected function beforeGeneration(): void
    {
    }

    protected function afterGeneration(): void
    {
    }

    abstract protected function stubOptions(): array;

    protected final function defaultStubOptions(): array
    {
        return [
            "LOWER_MODULE" => strtolower($this->getModuleName()),
            "MODULE" => $this->getModuleName(),
            "PLURAL_MODULE" => Str::plural($this->getModuleName()),
            "PLURAL_LOWER_MODULE" => strtolower(Str::plural($this->getModuleName())),
            "CLEAN_NAME" => $this->getCleanName()
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    final protected function getOptions()
    {
        $options = $this->setOptions();
        $options[] = ['overwrite', null, InputOption::VALUE_NONE, 'Overwrite this file if it already exists?'];
        return $options;
    }


    protected function getCleanName(): string
    {
        $className = str_replace('.php', '', $this->getFileName());
        return str_ireplace(strtolower($this->getGeneratorName()), '', $className);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    final protected function getArguments()
    {
        return array_merge([
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ],
            $this->setArguments());
    }

    /**
     * Set the console command arguments.
     *
     * @return array
     */
    protected abstract function setArguments(): array;

    /**
     * Set the console command options.
     *
     * @return array
     */
    protected abstract function setOptions(): array;


    protected function getGeneratorName(): string
    {
        return $this->generatorName ?? 'class';
    }

    /**
     * Get the stub file name.
     * @return string
     */
    protected function stubName()
    {
        return $this->stub;
    }

    protected function handleOptions()
    {
        foreach ($this->getOptions() as $option) {
            $method = 'handle' . ucfirst(strtolower($option[0])) . 'Option';
            $originalInput = $this->getOriginalOptionInput();
            if (isset($originalInput[$option[0]])) {
                $this->optionData[$option[0]] = $originalInput[$option[0]];
            } else {
                $this->optionData[$option[0]] = method_exists($this, $method) ? $this->$method($option[1], $option[2], $option[3], $option[4] ?? null) : $this->option($option[0]);
            }
        }
    }

    protected function handleModuleArgument()
    {
        return $this->anticipate('For what module would you like to generate a ' . $this->getGeneratorName() . '.', Larapi::getModuleNames());
    }

    protected function getModuleName()
    {
        $moduleName = $this->getArgument('module');
        if ($moduleName === null) {
            $this->error('module not specified');
            throw new \Exception('Name of module not specified.');
        }
        return $moduleName;
    }

    protected function handleArguments()
    {
        foreach ($this->getArguments() as $argument) {
            $method = 'handle' . ucfirst(strtolower($argument[0])) . 'Argument';
            $originalInput = $this->getOriginalArgumentInput();
            if (isset($originalInput[$argument[0]])) {
                $this->argumentData[$argument[0]] = $originalInput[$argument[0]];
            } else {
                $this->argumentData[$argument[0]] = method_exists($this, $method) ? $this->$method($argument[1], $argument[2], $argument[3] ?? null) : $this->option($argument[0]);
            }
        }
    }

    protected function getArgument(string $argument)
    {
        return $this->argumentData[$argument];
    }

    protected function getOption(string $name)
    {
        return $this->optionData[$name];
    }

    private function getOriginalOptionInput()
    {
        $reflection = new ReflectionClass($this->input);
        $property = $reflection->getProperty('options');
        $property->setAccessible(true);
        return $property->getValue($this->input);
    }

    private function getOriginalArgumentInput()
    {
        $reflection = new ReflectionClass($this->input);
        $property = $reflection->getProperty('arguments');
        $property->setAccessible(true);
        return $property->getValue($this->input);
    }

    public function __call($method, $parameters)
    {
        $key = str_replace('get', '', $method);
        if (array_key_exists(strtolower($method), $this->optionData))
            return $this->optionData[$key];
    }

    protected function handleOverwriteOption($shortcut, $type, $question, $default)
    {
        if (file_exists($this->getFilteredPath())) {
            return $this->confirm('The file exists already. Would you like to overwrite it?', false);
        }
        return false;
    }
}
