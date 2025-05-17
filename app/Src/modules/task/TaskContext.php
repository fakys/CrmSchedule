<?php

namespace App\Src\modules\task;

use App\Src\BackendHelper;
use App\Src\modules\exceptions\BackendException;
use App\Src\modules\kernel\constructs\ConstructComponents;
use App\Src\traits\TraitObjects;

class TaskContext
{
    use TraitObjects;

    public function getTaskFromKernelByName($name)
    {
        $kernel = BackendHelper::getKernel();
        foreach ($kernel->getModules() as $module) {
            foreach ($module->getComponents() as $component) {
                if ($component->getType() == ConstructComponents::TASK_TYPE && $component->getComponent()->getName() == $name) {
                    return $component->getComponent();
                }
            }
        }
        throw new BackendException("Таск с именем $name не найден");
    }
}
