<?php
namespace App\Modules\Crm\student_groups;


use App\Modules\Crm\student_groups\repositories\SpecialtiesRepositories;
use App\Modules\Crm\student_groups\repositories\StudentGroupRepositories;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'student_groups';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль групп студентов';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за группы студентов и их настройку';
    }

    public static function repositories(): array
    {
        return [
            SpecialtiesRepositories::class,
            StudentGroupRepositories::class
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
}
