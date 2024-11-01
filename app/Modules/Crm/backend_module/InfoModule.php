<?php
namespace App\Modules\Crm\backend_module;

use App\Modules\Crm\backend_module\componnets\repositories\TestRepository;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;

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
            TestRepository::class
        ];
    }

    public static function operations(): array
    {
        return [];
    }
}
