<?php

namespace App\Src\modules\kernel;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\crons_schedule\AbstractCronSchedule;
use App\Src\modules\exceptions\BackendException;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\constructs\ConstructComponents;
use App\Src\modules\kernel\constructs\ConstructControllers;
use App\Src\modules\kernel\entity\ComponentsEntity;
use App\Src\modules\kernel\entity\ModuleEntity;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;

class KernelConstructor
{
    const MODULE_KEY = 'modules';
    const KERNEL_CONSTRUCT = 'kernel_construct';

    /**
     * @var KernelConstructor
     */
    private static $kernel;

    /**
     * @var ConstructControllers
     */
    private $construct_controllers;

    /**
     * @var ConstructComponents
     */
    private $construct_components;

    /** @var Application */
    private $app;


    /** Инициализируем ядро */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function InitKernel()
    {
        //Загружаем компоненты
        $this->constructModuleComponents();
        //Загружаем контроллеры
        $this->constructControllers();
    }

    public static function createKernel($app)
    {
        if (!self::$kernel) {
            self::$kernel = new KernelConstructor($app);
        }
        return self::$kernel;
    }

    /**
     * @return KernelConstructor
     */
    public static function getKernelModule()
    {
        return self::$kernel;
    }

    /**
     * @return ConstructControllers
     */
    private function constructControllers()
    {
        $this->construct_controllers = ConstructControllers::constructObject($this);
        $this->construct_controllers->collectControllerByModulesForKernel();
        return $this->construct_controllers;
    }

    /**
     * @return ConstructComponents
     */
    private function constructModuleComponents()
    {
        $this->construct_components = ConstructComponents::constructComponents($this);
        return $this->construct_components;
    }

    /**
     * @return \App\Src\modules\controllers\ControllerLoader
     */
    public function getControllerLoader()
    {
        return $this->construct_controllers->getControllerLoaderForKernel();
    }

    public function getComponentsByTag($component_name)
    {
        return $this->construct_components->getComponentsForKernelByTag($component_name);
    }

    /**
     * @return ModuleEntity[]
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getModules()
    {
        return $this->app->get(KernelConstructor::MODULE_KEY);
    }
}
