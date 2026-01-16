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
                    $tag_components = BackendHelper::getKernel()->getComponentsByTag($component->getName());
                    if (
                        $component->getType() == ConstructComponents::OPERATION_TYPE
                        && method_exists($component->getComponent(), $name) && $tag_components
                    ) {
                        if (
                            isset($tag_components[AbstractOperation::BEFORE_TYPE]) &&
                            $tag_components[AbstractOperation::BEFORE_TYPE] &&
                            $tag_components[AbstractOperation::BEFORE_TYPE][array_key_first($tag_components[AbstractOperation::BEFORE_TYPE])] &&
                            method_exists(
                                $tag_components[AbstractOperation::BEFORE_TYPE][array_key_first($tag_components[AbstractOperation::BEFORE_TYPE])],
                                $name
                            )
                        ) {
                            return call_user_func_array(
                                [
                                    $tag_components[AbstractOperation::BEFORE_TYPE][array_key_first($tag_components[AbstractOperation::BEFORE_TYPE])],
                                    $name
                                ],
                                $arguments
                            );
                        } else {
                            return call_user_func_array([$component->getComponent(), $name], $arguments);
                        }
                    }
                }
            }
        }
    }
}
