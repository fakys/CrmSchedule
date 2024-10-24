<?php
namespace App\Src\modules;

use App\Src\traits\TraitObjects;

class InfoModuleModel{
    use TraitObjects;
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

    public static function getInfoModuleByName($name_module)
    {

    }
}
