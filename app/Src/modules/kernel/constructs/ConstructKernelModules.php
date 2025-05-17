<?php

namespace App\Src\modules\kernel\constructs;

use App\Src\modules\InfoModuleModel;
use App\Src\modules\kernel\entity\ModuleEntity;
use App\Src\modules\kernel\KernelModules;
use App\Src\traits\TraitObjects;

/** Выполняет сборку модулей для ядра */
class ConstructKernelModules
{
    use TraitObjects;

    /**
     * @var KernelModules
     */
    private $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }
    /**
     * @return ConstructKernelModules
     */
    public static function constructModules($kernel)
    {
        return self::objects($kernel)->collectModulesForKernel();
    }


    public function collectModulesForKernel()
    {
        $modules = InfoModuleModel::objects()->getFullInfoModules();
        $modules_objects = [];

        foreach ($modules as $module_name => $module) {
            $modules_objects[$module_name] = new ModuleEntity(new $module());;
        }

        $this->kernel->setModules($modules_objects);
        return $this;
    }
}
