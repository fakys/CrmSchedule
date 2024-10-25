<?php
namespace App\Src\modules;

use App\Src\traits\TraitObjects;

class InfoModuleModel{
    use TraitObjects;
    private $config;
    public function __construct()
    {
        $this->config = config('modules');
    }

    public static function getInfo(){
        return self::objects([],true)->getFullInfoModule();
    }
    public function getFullInfoModule()
    {
        return [
            'name'=>self::$objects->getNameModule(),
            'ru_name'=>self::$objects->getRuNameModule(),
            'description'=>self::$objects->getDescriptionModule(),
        ];
    }

    public function getInfoModuleByName(string $name_module)
    {
        $path = $this->config['base_path'];
        foreach ($this->config['modules'] as $module_name => $modules){
            foreach ($modules as $module){
                $module_path = "$path/$module_name/$module/InfoModule.php";
                if(file_exists($module_path)){
                    return "{$this->config['base_namespace']}\\$module_name\\$module\\InfoModule";
                }
            }
        }
    }
}
