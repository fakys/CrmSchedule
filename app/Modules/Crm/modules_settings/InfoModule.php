<?php
namespace App\Modules\Crm\modules_settings;


use App\Modules\Crm\modules_settings\operations\ConfigModulesOperations;
use App\Modules\Crm\modules_settings\operations\StatusModulesOperation;
use App\Modules\Crm\modules_settings\repositories\ModulesRepository;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'modules_settings';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль настроек модулей';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за настройки модулей';
    }

    public static function repositories(): array
    {
        return [
            ModulesRepository::class
        ];
    }

    public static function operations(): array
    {
        return [
            ConfigModulesOperations::class,
            StatusModulesOperation::class
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
}
