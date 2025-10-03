<?php
namespace App\Modules\RestApi\schedule_api;


use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'schedule_api';
    }

    public static function getRuNameModule(): string
    {
        return 'Api модуль для расписания';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за отправку данных о расписание на сайт';
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
        return [];
    }
}
