<?php
namespace App\Modules\Crm\schedule;


use App\Modules\Crm\schedule\operations\ScheduleManagerOperation;
use App\Modules\Crm\schedule\operations\SemestersOperation;
use App\Modules\Crm\schedule\operations\TimeOperation;
use App\Modules\Crm\schedule\repositories\ScheduleRepository;
use App\Modules\Crm\schedule\repositories\SemestersRepository;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'schedule';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль расписания';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за расписание и его настройку';
    }

    public static function repositories(): array
    {
        return [
            ScheduleRepository::class,
            SemestersRepository::class
        ];
    }

    public static function operations(): array
    {
        return [
            ScheduleManagerOperation::class,
            TimeOperation::class,
            SemestersOperation::class
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
}
