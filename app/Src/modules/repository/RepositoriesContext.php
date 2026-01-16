<?php

namespace App\Src\modules\repository;

use App\Src\BackendHelper;
use App\Src\modules\exceptions\BackendException;
use App\Src\modules\kernel\constructs\ConstructComponents;
use App\Src\traits\TraitObjects;

class RepositoriesContext
{
    use TraitObjects;

    public function __call(string $name, array $arguments)
    {
        $modules = BackendHelper::getKernel()->getModules();

        foreach ($modules as $module) {
            if ($module->getComponents()) {
                foreach ($module->getComponents() as $component) {
                    if (
                        $component->getType() == ConstructComponents::REPOSITORY_TYPE
                        && method_exists($component->getComponent(), $name)
                    ) {
                        return call_user_func_array([$component->getComponent(), $name], $arguments);
                    }
                }
            }
        }
        throw new BackendException("Метод $name не найден");
    }
}
