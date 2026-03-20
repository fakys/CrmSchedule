<?php
namespace App\Modules\Crm\interface;

use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'interface';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль интерфейса';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за отображение главного интерфейса';
    }

    public function requireModule(): bool
    {
        return true;
    }
}
