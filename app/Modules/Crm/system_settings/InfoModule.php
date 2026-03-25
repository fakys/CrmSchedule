<?php
namespace App\Modules\Crm\system_settings;

use App\Modules\Crm\system_settings\components\operations\SystemSettingsOperations;
use App\Modules\Crm\system_settings\components\repositories\SystemSettingRepository;
use App\Modules\Crm\system_settings\components\settings\CrmSetting;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Modules\Crm\system_settings\components\settings\SystemSetting;
use App\Modules\Crm\system_settings\controllers\SettingsController;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'system_settings';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль настроек системы';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за настройки системы';
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

    public static function controllers(): array
    {
        return [
            SettingsController::class
        ];
    }

    public static function components(): array
    {
        return [
            CrmSetting::class,
            SystemSetting::class,
            ScheduleSetting::class
        ];
    }

    public function requireModule(): bool
    {
        return true;
    }
}
