<?php

namespace App\Src\routes;

use App\Src\modules\InfoModuleModel;
use App\Src\traits\TraitObjects;

class ModuleRoute
{
    use TraitObjects;

    private $route;
    private array $config;
    private string $main_module;

    public function __construct($data)
    {
        $this->route = $data['route'];
        $this->config = $data['config'];
        $this->main_module = $data['main_module'];
    }

    public static function route($data)
    {

        return self::objects($data)->getModuleRoute();
    }

    public function getModuleRoute()
    {
        $modules = $this->config['modules'][$this->main_module];
        foreach ($modules as $module) {
            $path = $this->config['base_path'] . "/{$this->main_module}/$module/{$this->config['web_path']}";
            $namespace = $this->config['base_namespace'] . "\\{$this->main_module}\\controllers";
            if (file_exists($path)) {
                $this->route::namespace($namespace)->group($path);
            }
        }
    }
}
