<?php

namespace App\Src\modules\kernel;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\crons_schedule\AbstractCronSchedule;
use App\Src\modules\exceptions\BackendException;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\constructs\ConstructComponents;
use App\Src\modules\kernel\constructs\ConstructKernelModules;
use App\Src\modules\kernel\entity\ComponentsEntity;
use App\Src\modules\kernel\entity\ModuleEntity;

class KernelModules
{
    /**
     * @var KernelModules
     */
    private static $kernel;

    /**
     * @var ModuleEntity[]
     */
    private $modules;

    /**
     * @var ConstructComponents
     */
    private $construct_components;

    /**
     * @var ConstructKernelModules
     */
    private $construct_kernel_modules;


    /** Инициализируем ядро */
    public function __construct()
    {
        $this->constructModules();
        $this->constructModuleComponents();
    }

    private static function createKernel()
    {
        self::$kernel = new KernelModules();
    }

    /**
     * @return KernelModules
     */
    public static function getKernelModule()
    {
        if (!self::$kernel) {
            self::createKernel();
        }

        return self::$kernel;
    }

    /**
     * @return ConstructKernelModules
     */
    private function constructModules()
    {
        $this->construct_kernel_modules = ConstructKernelModules::constructModules($this);
        return $this->construct_kernel_modules;
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
     * @param ModuleEntity[] $modules
     * @return void
     */
    public function setModules($modules)
    {
        $this->modules = $modules;
    }

    /**
     * @return ModuleEntity[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    public function getModulByName($nameModule)
    {
        try {
            return $this->modules[$nameModule];
        } catch (\Exception $e) {
            throw new BackendException("Модуль по названию $nameModule ненайден");
        }
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
}
