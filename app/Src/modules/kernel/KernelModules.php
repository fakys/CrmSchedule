<?php

namespace App\Src\modules\kernel;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\constructs\ConstructComponents;
use App\Src\modules\kernel\constructs\ConstructKernelModules;
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
}
