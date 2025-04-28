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
        return ConstructKernelModules::constructModules($this);
    }

    /**
     * @return ConstructComponents
     */
    private function constructModuleComponents()
    {
        return ConstructComponents::constructComponents($this);
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
