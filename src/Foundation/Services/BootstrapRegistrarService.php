<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 04.10.18
 * Time: 02:13.
 */

namespace Foundation\Services;

use Foundation\Abstracts\Listeners\Listener;
use Foundation\Abstracts\Observers\Observer;
use Foundation\Abstracts\Policies\Policy;
use Foundation\Contracts\ConditionalAutoRegistration;
use Foundation\Contracts\Ownable;
use Foundation\Core\Larapi;
use Foundation\Traits\Cacheable;

class BootstrapRegistrarService
{
    /**
     * @var string
     */
    protected $cacheFile = 'bootstrap.php';

    /**
     * @var
     */
    protected $bootstrap;

    public function recache()
    {
        $this->bootstrap();

        $this->storeInCache($this->bootstrap);
    }

    /**
     * @param $data
     */
    private function storeInCache($data)
    {
        file_put_contents($this->getCachePath(), '<?php return '.var_export($data, true).';');
    }

    /**
     * @return mixed
     */
    public function readFromCache()
    {
        return include $this->getCachePath();
    }

    public function clearCache()
    {
        unlink($this->getCachePath());
    }

    /**
     * @return bool
     */
    public function cacheExists()
    {
        return file_exists($this->getCachePath());
    }

    /**
     * @return string
     */
    private function getCachePath(): string
    {
        return app()->bootstrapPath().'/cache/'.$this->cacheFile;
    }

    public function bootstrap()
    {
        foreach (Larapi::getModules() as $module) {
            $this->bootstrapCommands($module);
            $this->bootstrapRoutes($module);
            $this->bootstrapConfigs($module);
            $this->bootstrapFactories($module);
            $this->bootstrapMigrations($module);
            $this->bootstrapModels($module);
            $this->bootstrapSeeders($module);
            $this->bootstrapProviders($module);
            $this->bootstrapEvents($module);
        }
    }

    private function bootstrapCommands(\Foundation\Core\Module $module)
    {
        foreach ($module->getCommands()->getClasses() as $commandClass) {
            $this->bootstrap['commands'][] = [
                'class' => $commandClass,
            ];
        }
    }

    private function bootstrapRoutes(\Foundation\Core\Module $module)
    {
        foreach ($module->getRoutes()->getFiles() as $file) {
            $this->bootstrap['routes'][] = [
                'prefix' => $this->generateRoutePrefixFromFileName($file->getFileName()),
                'controller_namespace' => $module->getControllers()->getNamespace(),
                'domain' => Larapi::getApiDomainName(),
                'path' => $file->getPath(),
                'module_model' => $module->getMainModel(),
            ];
        }
    }

    private function generateRoutePrefixFromFileName(string $fileName)
    {
        $prefixArray = explode('.', $fileName);
        $prefixVersion = $prefixArray[1];
        $prefixRoute = $prefixArray[0];

        return $prefixVersion.'/'.$prefixRoute;
    }

    private function bootstrapConfigs(\Foundation\Core\Module $module)
    {
        foreach ($module->getConfigs()->getFiles() as $file) {
            $this->bootstrap['configs'][] = [
                'name' => $file->getName(),
                'path' => $file->getPath(),
            ];
        }
    }

    private function bootstrapFactories(\Foundation\Core\Module $module)
    {
        $this->bootstrap['factories'][] = [
            'path' => $module->getFactories()->getPath(),
        ];
    }

    private function bootstrapMigrations(\Foundation\Core\Module $module)
    {
        $this->bootstrap['migrations'][] = [
            'path' => $module->getMigrations()->getPath(),
        ];
    }

    private function bootstrapSeeders(\Foundation\Core\Module $module)
    {
        foreach ($module->getSeeders()->getClasses() as $seederClass) {
            $this->bootstrap['seeders'][] = [
                'class' => $seederClass,
            ];
        }
    }

    private function bootstrapModels(\Foundation\Core\Module $module)
    {
        foreach ($module->getModels()->getClasses() as $modelClass) {
            $this->bootstrap['models'][] = [
                'class' => $modelClass,
                'observers' => $this->extractObserversFromModel($modelClass),
                'policies' => $this->extractPoliciesFromModel($modelClass),
                'cacheable' => class_uses_trait($modelClass, Cacheable::class),
                'ownable' => class_implements_interface($modelClass, Ownable::class),
            ];
        }
    }

    private function extractObserversFromModel(string $modelClass)
    {
        $observers = [];
        foreach (get_class_property($modelClass, 'observers') ?? [] as $observerClass) {
            if (instance_without_constructor($observerClass) instanceof Observer) {
                $observers[] = $observerClass;
            }
        }

        return $observers;
    }

    private function extractPoliciesFromModel(string $modelClass)
    {
        $policies = [];
        foreach (get_class_property($modelClass, 'policies') ?? [] as $policyClass) {
            if (instance_without_constructor($policyClass) instanceof Policy) {
                $policies[] = $policyClass;
            }
        }

        return $policies;
    }

    private function bootstrapProviders(\Foundation\Core\Module $module)
    {
        foreach ($module->getServiceProviders()->getClasses() as $serviceProviderClass) {
            if ($this->passedRegistrationCondition($serviceProviderClass)) {
                $this->bootstrap['providers'][] = [
                    'class' => $serviceProviderClass,
                ];
            }
        }
    }

    private function passedRegistrationCondition($class)
    {
        if (! class_implements_interface($class, ConditionalAutoRegistration::class)) {
            return true;
        }

        return call_class_function($class, 'registrationCondition');
    }

    private function bootstrapEvents(\Foundation\Core\Module $module)
    {
        foreach ($module->getEvents()->getClasses() as $eventClass) {
            $listeners = [];
            foreach (get_class_property($eventClass, 'listeners') ?? [] as $listenerClass) {
                $listener = instance_without_constructor($listenerClass);
                if (method_exists($listener, 'handle')) {
                    $listeners[] = $listenerClass;
                }
            }
            $this->bootstrap['events'][] = [
                'class' => $eventClass,
                'listeners' => $listeners,
            ];
        }
    }

    /**
     * @return mixed
     */
    public function loadBootstrapFromCache()
    {
        if (! isset($this->bootstrap)) {
            if ($this->cacheExists()) {
                $this->bootstrap = $this->readFromCache();
            } else {
                $this->recache();
            }
        }

        return $this->bootstrap;
    }

    public function loadNewBootstrap()
    {
        $this->bootstrap();

        return $this->bootstrap;
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->loadBootstrapFromCache()['commands'] ?? [];
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->loadBootstrapFromCache()['routes'] ?? [];
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->loadBootstrapFromCache()['configs'] ?? [];
    }

    /**
     * @return array
     */
    public function getFactories(): array
    {
        return $this->loadBootstrapFromCache()['factories'] ?? [];
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return $this->loadBootstrapFromCache()['migrations'] ?? [];
    }

    /**
     * @return array
     */
    public function getSeeders(): array
    {
        return $this->loadBootstrapFromCache()['seeders'] ?? [];
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        return $this->loadBootstrapFromCache()['models'] ?? [];
    }

    /**
     * @return array
     */
    public function getPolicies(): array
    {
        return $this->loadBootstrapFromCache()['policies'] ?? [];
    }

    /**
     * @return array
     */
    public function getProviders(): array
    {
        return $this->loadBootstrapFromCache()['providers'] ?? [];
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->loadBootstrapFromCache()['events'] ?? [];
    }
}
