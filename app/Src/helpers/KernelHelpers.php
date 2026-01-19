<?php

use App\Src\modules\kernel\entity\ComponentsEntity;

if (!function_exists('get_modules')) {
    /**
     * @return \App\Src\modules\kernel\entity\ModuleEntity[]
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function get_modules()
    {
        return app()->get(\App\Src\modules\kernel\KernelConstructor::MODULE_KEY);
    }
}

if (!function_exists('get_components_by_type')) {

    /**
     * @param $type
     * @return ComponentsEntity[]
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function get_components_by_type($type)
    {
        $data = [];
        foreach (get_modules() ?? [] as $module) {
            if ($module->getStatus()) {
                foreach ($module->getComponents() ?? [] as $component) {
                    if ($component->getType() === $type) {
                        $data[] = $component;
                    }
                }
            }
        }
        return $data;
    }
}

if (!function_exists('get_components_by_type')) {
    function get_components_by_name($name)
    {
        foreach (get_modules() ?? [] as $module) {
            foreach ($module->getComponents() ?? [] as $component) {
                if ($component->getName() === $name) {
                    return $component;
                }
            }
        }
        return [];
    }
}

