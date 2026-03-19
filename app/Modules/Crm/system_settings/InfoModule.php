<?php
namespace App\Modules\Crm\system_settings;

use App\Modules\Crm\system_settings\controllers\SettingsController;
use App\Modules\Crm\system_settings\operations\SystemSettingsOperations;
use App\Modules\Crm\system_settings\repositories\SystemSettingRepository;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

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
    public static function runConfig()
    {
        Config::set('view.paths', array(__DIR__.'/views'));
    }

    public static function tasks(): array
    {
        return  [];
    }

    public static function mangers(): array
    {
        return [];
    }

    public static function components(): array
    {
        return [];
    }

    public static function crons(): array
    {
        return [];
    }

    public static function controllers(): array
    {
        return [
            SettingsController::class
        ];
    }
}
