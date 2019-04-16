<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 12.03.19
 * Time: 16:01
 */

namespace Foundation\Generator\Factories;


use Foundation\Core\Larapi;
use Foundation\Core\Module;
use Foundation\Generator\Managers\GeneratorManager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Nwidart\Modules\Exceptions\FileAlreadyExistException;

/**
 * Class User.
 *
 * @method void addMigration(string $name, string $table, bool $mongo)
 * @method void addController(string $name)
 * @method void addPolicy(string $name)
 * @method void addEvent(string $name)
 * @method void addNotification(string $name)
 * @method void addServiceProvider(string $name)
 * @method void addSeeder(string $name)
 * @method void addMiddleware(string $name)
 * @method void addRequest(string $name)
 * @method void addRule(string $name)
 * @method void addRoute(string $version)
 * @method void addComposer()
 * @method void addTest(string $name, string $type)
 * @method void addFactory(string $modelName)
 * @method void addTransformer(string $name, string $model)
 * @method void addListener(string $name, string $event, bool $queued = false)
 * @method void addJob(string $name, bool $sync = false)
 * @method void addCommand(string $name, ?string $commandName = null)
 * @method void addModel(string $name, bool $mongo = false, bool $migration = true)
 * @method void addService(string $name, bool $dto = false)
 * @method void addServiceContract(string $name)
 * @method void addException(string $name)
 * @method void addPermission(string $name)
 * @method void addAttribute(string $name)
 * @method void addDto(string $name)
 * @method void addGuard(string $name)
 * @method void addRepository(string $name, string $model)
 * @method void addRepositoryContract(string $name)
 *
 */
class ModuleFactory
{

    /**
     * The module that will created.
     *
     * @var Module
     */
    protected $module;

    /**
     * The laravel filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Array of resources that will be generated upon execution.
     *
     * @var array
     */
    protected $pipeline = [];

    /**
     * The constructor.
     * @param string $moduleName
     * @throws FileAlreadyExistException
     */
    public function __construct(string $moduleName)
    {
        $this->module = $this->createModule($moduleName);
        $this->filesystem = new Filesystem();
    }

    private function createModule($moduleName): Module
    {
        $moduleName = Str::studly($moduleName);
        $path = Larapi::getModulesBasePath() . '/' . $moduleName;
        if (file_exists($path)) {
            throw new FileAlreadyExistException("Module exists already. Please remove the directory first");
        }
        return new Module($moduleName, Larapi::getModulesBasePath() . '/' . $moduleName);
    }

    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'add'))
            $this->pipeline[] = [
                "name" => Str::replaceFirst('add', '', $name),
                "arguments" => $arguments
            ];

    }

    public function build()
    {
        foreach ($this->pipeline as $command) {
            $manager = GeneratorManager::module($this->getModule()->getName());
            $method = 'create' . $command['name'];
            call_user_func_array(array($manager, $method), $command['arguments']);
        }
    }

    /**
     * Get the name of module will created. By default in studly case.
     *
     * @return string
     */
    protected function getName()
    {
        return $this->module->getName();
    }

    /**
     * Get the laravel filesystem instance.
     *
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
    }

    /**
     * @return array
     */
    public function getPipeline(): array
    {
        return $this->pipeline;
    }
}
