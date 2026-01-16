<?php

namespace App\Src\modules;

use App\Src\BackendHelper;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\traits\TraitObjects;

class ModulesHelper
{
    use TraitObjects;

    private $config;
    private $context_module;

    public function __construct()
    {
        $this->config = config('modules');
    }

    public static function getInfo()
    {
        return self::objects([], true)->getFullInfoModule();
    }

    /**
     * @return InterfaceInfoModule
     */
    public function getContextModule($module)
    {
        if(self::objects()->context_module){
            return self::objects()->context_module;
        }
        return $this->getInfoModuleByName($module);
    }

    public function getFullInfoModule()
    {
        return [
            'name' => self::$objects->getNameModule(),
            'ru_name' => self::$objects->getRuNameModule(),
            'description' => self::$objects->getDescriptionModule(),
        ];
    }

    /**
     * @param string $name_module
     * @return InterfaceInfoModule
     */
    public function getInfoModuleByName(string $name_module)
    {
        return BackendHelper::getKernel()->getModuleByName($name_module)->getModule();
    }
}
