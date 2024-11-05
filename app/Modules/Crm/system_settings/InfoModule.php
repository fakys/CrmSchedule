<?php
namespace App\Modules\Crm\system_settings;

use App\Modules\Crm\system_settings\operations\SystemSettingsOperations;
use App\Modules\Crm\system_settings\repositories\SystemSettingRepository;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'interface';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль интерфейса';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за отображение главного интерфейса';
    }

    public static function repositories(): array
    {
        return [
            SystemSettingRepository::class
        ];
    }

    public static function operations(): array
    {
        return [
            SystemSettingsOperations::class
        ];
    }
    public static function runConfig()
    {
        Config::set('view.paths', array(__DIR__.'/views'));
    }
}
