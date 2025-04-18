<?php
namespace App\Modules\Crm\reports;

use App\Modules\Crm\reports\operations\ReportsOperation;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'reports';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль отчетов';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за отчеты';
    }

    public static function repositories(): array
    {
        return [

        ];
    }

    public static function operations(): array
    {
        return [
            ReportsOperation::class
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
        return [
        ];
    }
}
