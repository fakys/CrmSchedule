<?php

namespace App\Src\routes;

use App\Middleware\AuthMiddleware;
use App\Src\traits\TraitObjects;
use Illuminate\Support\Facades\Route;

class ModuleRoute
{
    use TraitObjects;

    /** @var Route*/
    private $route;
    private array $config;

    public function __construct($data)
    {
        $this->route = $data['route'];
        $this->config = $data['config'];
    }

    public static function route($data, $main_module)
    {

        return self::objects($data)->getModuleRoute($main_module);
    }

    public function getModuleRoute($main_module)
    {

        $modules = $this->config['modules'][$main_module];
        foreach ($modules as $module) {
            $path = $this->config['base_path'] . "/{$main_module}/$module/{$this->config['web_path']}";
            $namespace = $this->config['base_namespace'] . "\\{$main_module}\\$module\\controllers";
            if (file_exists($path)) {
                if (!in_array($module, $this->config['public_modules'])) {
                    $this->route::namespace($namespace)->middleware(AuthMiddleware::class)->group($path);
                }else{
                    $this->route::namespace($namespace)->group($path);
                }
            }
        }
    }
}
