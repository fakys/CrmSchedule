<?php
namespace App\Modules\Crm\holidays;


use App\Modules\Crm\holidays\operations\HolidayOperation;
use App\Modules\Crm\holidays\repositories\HolidayRepository;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'holidays';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль праздничных дней';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за праздничные дни и их настройку';
    }

    public static function repositories(): array
    {
        return [
            HolidayRepository::class
        ];
    }

    public static function operations(): array
    {
        return [
            HolidayOperation::class
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
