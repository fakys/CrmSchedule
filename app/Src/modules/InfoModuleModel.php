<?php

namespace App\Src\modules;

use App\Src\traits\TraitObjects;

class InfoModuleModel
{
    use TraitObjects;

    private $config;

    public function __construct()
    {
        $this->config = config('modules');
    }

    public static function getInfo()
    {
        return self::objects([], true)->getFullInfoModule();
    }

    public function getFullInfoModule()
    {
        return [
            'name' => self::$objects->getNameModule(),
            'ru_name' => self::$objects->getRuNameModule(),
            'description' => self::$objects->getDescriptionModule(),
        ];
    }

    public function getInfoModuleByName(string $name_module)
    {
        $path = $this->config['base_path'];
        foreach ($this->config['modules'] as $module_name => $modules) {
            foreach ($modules as $module) {
                if ($name_module == $module) {
                    $module_path = "$path/$module_name/$module/InfoModule.php";
                    if (file_exists($module_path)) {
                        return new ("{$this->config['base_namespace']}\\$module_name\\$module\\InfoModule")();
                    }
                }
            }
        }
        return null;
    }

    public function getNamespaceModuleByName(string $name_module)
    {
        $path = $this->config['base_path'];
        foreach ($this->config['modules'] as $module_name => $modules) {
            foreach ($modules as $module) {
                if ($name_module == $module) {
                    $module_path = "$path/$module_name/$module/InfoModule.php";
                    if (file_exists($module_path)) {
                        return "{$this->config['base_namespace']}\\$module_name\\$module";
                    }
                }
            }
        }
        return null;
    }

    public function getFullInfoModules()
    {
        $arr_modules = [];
        $path = $this->config['base_path'];
        foreach ($this->config['modules'] as $module_name => $modules) {
            foreach ($modules as $module) {
                $module_path = "$path/$module_name/$module/InfoModule.php";
                if (file_exists($module_path)) {
                    $arr_modules[$module] = "{$this->config['base_namespace']}\\$module_name\\$module\\InfoModule";
                }
            }
        }
        return $arr_modules;
    }
}
