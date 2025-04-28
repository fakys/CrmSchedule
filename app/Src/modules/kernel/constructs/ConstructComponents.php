<?php

namespace App\Src\modules\kernel\constructs;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\entity\ComponentsEntity;
use App\Src\modules\kernel\KernelModules;
use App\Src\modules\operations\AbstractOperation;
use App\Src\traits\TraitObjects;


/** Выполняет сборку компонентов для ядра */
class ConstructComponents
{
    use TraitObjects;

    const OPERATION_TYPE = 'operation';

    /**
     * @var KernelModules
     */
    private $kernel;

    private $components;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }
    /**
     * @return constructComponents
     */
    public static function constructComponents($kernel)
    {
        return self::objects($kernel)->collectComponentsByModulesForKernel();
    }

    public function collectComponentsByModulesForKernel()
    {
        foreach ($this->kernel->getModules()??[] as $module) {

            foreach ($module->getModule()->operations() as $operation) {
                $obj = new $operation($this->kernel);
                if ($obj instanceof AbstractComponents) {
                    $module->appendComponents(new ComponentsEntity(self::OPERATION_TYPE, $obj->getName(), $obj));
                    $this->components[$obj->getName()] = $obj;
                }
            }
//            $module->repositories();
//            $module->tasks();
//            $module->mangers();
        }
        return $this;
    }
}
