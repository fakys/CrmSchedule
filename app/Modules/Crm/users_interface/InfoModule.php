<?php
namespace App\Modules\Crm\users_interface;

use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'users_interface';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль управления пользователями';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за управления пользователями и их ролями';
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
