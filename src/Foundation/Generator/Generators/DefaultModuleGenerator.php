<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 23.03.19
 * Time: 00:51
 */

namespace Foundation\Generator\Generators;


use Foundation\Generator\Factories\ModuleFactory;

/**
 * Class DefaultModuleGenerator
 * @package Foundation\Generator\Generators
 */
class DefaultModuleGenerator
{
    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @var ModuleFactory
     */
    protected $moduleFactory;

    /**
     * DefaultModuleGenerator constructor.
     * @param $moduleFactory
     */
    public function __construct(string $moduleName)
    {
        $this->moduleName = $moduleName;
        $this->moduleFactory = new ModuleFactory($moduleName);
    }

    /**
     *
     */
    public function generate(){

        $this->moduleFactory->addModel($this->moduleName, true, true);

        $this->moduleFactory->addRepository($this->moduleName . 'Repository', $this->moduleName);

        $this->moduleFactory->addService($this->moduleName . 'Service',true);

        $this->moduleFactory->addController($this->moduleName . "Controller", true);

        $this->moduleFactory->addTest($this->moduleName . 'ServiceTest', 'service');
        $this->moduleFactory->addTest($this->moduleName . 'HttpTest', 'http');
        $this->moduleFactory->addTest($this->moduleName . 'UnitTest', 'unit');

        $this->moduleFactory->addEvent($this->moduleName . 'WasCreatedEvent');
        $this->moduleFactory->addEvent($this->moduleName . 'WasUpdatedEvent');
        $this->moduleFactory->addEvent($this->moduleName . 'WasDeletedEvent');

        $this->moduleFactory->addRequest('Find'.$this->moduleName . 'Request');
        $this->moduleFactory->addRequest('Index'.$this->moduleName . 'Request');
        $this->moduleFactory->addRequest('Create'.$this->moduleName . 'Request');
        $this->moduleFactory->addRequest('Update'.$this->moduleName . 'Request');
        $this->moduleFactory->addRequest('Delete'.$this->moduleName . 'Request');

        $this->moduleFactory->addPermission($this->moduleName . 'Permission');

        $this->moduleFactory->addPolicy($this->moduleName . 'Policy');

        $this->moduleFactory->addFactory($this->moduleName);

        $this->moduleFactory->addTransformer($this->moduleName.'Transformer', $this->moduleName);

        $this->moduleFactory->addServiceProvider($this->moduleName . 'ServiceProvider');

        $this->moduleFactory->addRoute('v1');

        $this->moduleFactory->addComposer();

        $this->moduleFactory->build();
    }


}
