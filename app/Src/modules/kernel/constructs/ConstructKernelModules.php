<?php

namespace App\Src\modules\kernel\constructs;

use App\Entity\StatusModules;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
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
    private $status_modules;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
        $this->getStatusModules();
    }
    /**
     * @return ConstructKernelModules
     */
    public static function constructModules($kernel)
    {
        return self::objects($kernel)->collectModulesForKernel();
    }

    private function getStatusModules()
    {
        $status = StatusModules::all();
        foreach ($status as $module) {
            $this->status_modules[$module->name] = (bool)$module->active;
        }
    }

    public function collectModulesForKernel()
    {
        $modules = InfoModuleModel::objects()->getFullInfoModules();
        $modules_objects = [];

        foreach ($modules as $module_name => $module) {
            /** @var InterfaceInfoModule $obj_module */
            $obj_module = new $module();
            $modules_objects[$module_name] = new ModuleEntity(
                $obj_module,
                isset($this->status_modules[$obj_module->getNameModule()]) ?
                    $this->status_modules[$obj_module->getNameModule()] : false
            );
        }

        $this->kernel->setModules($modules_objects);
        return $this;
    }
}
