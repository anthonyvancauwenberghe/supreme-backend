<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 21:51.
 */

namespace Foundation\Core;

final class Resource
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $subPath;

    /**
     * @var Module
     */
    protected $module;

    /**
     * @var string|null
     */
    protected $baseClass;

    /**
     * @var File[]
     */
    protected $files = [];

    /**
     * LarapiModule constructor.
     * @param $name
     */
    public function __construct(string $name, string $subPath, Module $module, ?string $baseClass = null)
    {
        $this->name = $name;
        $this->subPath = $subPath;
        $this->module = $module;
        $this->baseClass = $baseClass;
        $this->boot();
    }

    protected function boot()
    {
        $this->setFiles();
    }

    protected function setFiles()
    {
        $files = $this->getAllPhpFileNamesWithoutExtension();
        foreach ($files as $file) {
            $this->files[] = new File($file, $this->getPath().'/'.$file.'.php', $this);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSubPath(): string
    {
        return $this->subPath;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->module->getPath().$this->subPath;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->module->getNamespace().str_replace('/', '\\', $this->getSubPath());
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return count($this->getClasses());
    }

    /**
     * @return string[]
     */
    public function getClasses(): array
    {
        $classes = [];
        foreach ($this->getAllPhpFileNames() as $file) {
            $shortClassName = str_replace('.php', '', $file);
            $class = $this->getNamespace().'\\'.$shortClassName;

            if ($this->baseClass === null || instance_without_constructor($class) instanceof $this->baseClass) {
                $classes[] = $class;
            }
        }

        return $classes;
    }

    /**
     * @return File[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    public function getAllFileNames()
    {
        try {
            $fileNames = array_diff(scandir($this->getPath()), ['..', '.']);
        } catch (\ErrorException $e) {
            $fileNames = [];
        }

        return $fileNames;
    }

    public function getAllPhpFileNames()
    {
        $files = [];
        foreach ($this->getAllFileNames() as $file) {
            if ($this->hasPhpExtension($file)) {
                $files[] = $file;
            }
        }

        return $files;
    }

    public function getAllPhpFileNamesWithoutExtension()
    {
        $files = [];
        foreach ($this->getAllFileNames() as $file) {
            if ($this->hasPhpExtension($file)) {
                $files[] = str_replace('.php', '', $file);
            }
        }

        return $files;
    }

    /**
     * @param string $fileName
     *
     * @return bool
     */
    private function hasPhpExtension(string $fileName): bool
    {
        return strlen($fileName) > 4 && '.php' === ($fileName[-4].$fileName[-3].$fileName[-2].$fileName[-1]);
    }

    /**
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
    }

    /**
     * @return string|null
     */
    public function getBaseClass(): ?string
    {
        return $this->baseClass;
    }

    public function getClassByName(string $className): ?string
    {
        foreach ($this->getClasses() as $class) {
            if (strtolower((get_short_class_name($class)) === strtolower($className))) {
                return $class;
            }
        }

        return null;
    }
}
