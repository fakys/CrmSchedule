<?php
namespace App\Src;

use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;

class BackendHelper{

    /**
     * @param string $module
     * @return InterfaceInfoModule
     */
    public static function getModule(string $module)
    {
        return  InfoModuleModel::objects()->getInfoModuleByName($module);
    }
}
