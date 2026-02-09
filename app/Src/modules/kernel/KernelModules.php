<?php

namespace App\Src\modules\kernel;

use App\Entity\StatusModules;
use App\Src\Context;
use Illuminate\Http\Request;
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

class KernelModules
{
    const MODULE_KEY = 'modules';
    const KERNEL_KEY = 'kernel';

    /**
     * @var KernelModules
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
        $this->checkStatusModule();
        $this->constructModuleComponents();
        $this->constructControllers();
    }

    public static function createKernel($app)
    {
        if (!self::$kernel) {
            self::$kernel = new KernelModules($app);
        }
        return self::$kernel;
    }

    /**
     * @return KernelModules
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

    private function checkStatusModule()
    {
        foreach ($this->app->get(self::MODULE_KEY) as $module_name => $module_entity) {
            //Если модуль обязательный всегда подгружаем его
            if ($module_entity->getModule()->requiredModule()) {
                $module_entity->setStatus(true);
                 continue;
            }
            if (!app()->runningInConsole()) {
                /** @var StatusModules $status */
                $status = StatusModules::where(['name' => $module_entity->getModule()->getNameModule()])->first();
                if ($status) {
                    $module_entity->setStatus($status->active);
                }
                continue;
            }
            $module_entity->setStatus(true);
        }

    }

    /**
     * @return \App\Src\modules\controllers\ControllerLoader
     */
    public function getControllerLoader()
    {
        return $this->construct_controllers->getControllerLoaderForKernel();
    }

    /**
     * @param string $nameModule
     * @return ModuleEntity
     * @throws BackendException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface\
     */
    public function getModuleByName($nameModule)
    {
        try {
            /** @var Collection $modules */
            $modules = $this->getLaravelApp()->get(KernelModules::MODULE_KEY);
            return $modules[$nameModule];
        } catch (\Exception $e) {
            throw new BackendException("Модуль по названию $nameModule ненайден");
        }
    }

    public function getComponentsByTag($component_name)
    {
        return $this->construct_components->getComponentsForKernelByTag($component_name);
    }

    public function getComponentByName($component_name)
    {
        return $this->construct_components->getComponentsForKernelByName($component_name);
    }

    /**
     * @param $type
     * @return ComponentsEntity[]
     */
    public function getComponentsByType($type)
    {
        return $this->construct_components->getComponentsForKernelByType($type);
    }

    /**
     * @return Application
     */
    public function getLaravelApp()
    {
        return $this->app;
    }

    /**
     * @return ModuleEntity[]
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getModules()
    {
        return $this->app->get(KernelModules::MODULE_KEY);
    }

    public function getContext()
    {
        return Context::GetContext(Request::capture());
    }
}
