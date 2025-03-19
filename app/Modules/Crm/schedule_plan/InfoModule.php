<?php
namespace App\Modules\Crm\schedule_plan;


use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'schedule_plan';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль плана расписания';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за план расписания и его настройку';
    }

    public static function repositories(): array
    {
        return [
        ];
    }

    public static function operations(): array
    {
        return [
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
}
