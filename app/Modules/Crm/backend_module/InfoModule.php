<?php
namespace App\Modules\Crm\backend_module;

use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'backend_module';
    }

    public static function getRuNameModule(): string
    {
        return 'Основной модуль';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за основную БЛ проекта';
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
}
