<?php

namespace App\Src\modules\operations;


use App\Src\BackendHelper;
use App\Src\modules\kernel\constructs\ConstructComponents;
use App\Src\traits\TraitObjects;

class OperationsContext
{
    use TraitObjects;

    public function __call(string $name, array $arguments)
    {
        $modules = BackendHelper::getKernel()->getModules();

        foreach ($modules as $module) {
            if ($module->getComponents()) {
                foreach ($module->getComponents() as $component) {
                    if (
                        $component->getType() == ConstructComponents::OPERATION_TYPE
                        && method_exists($component->getComponent(), $name)
                    ) {
                        return call_user_func_array([$component->getComponent(), $name], $arguments);
                    }
                }
            }
        }
    }
}
