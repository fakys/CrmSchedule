<?php
namespace App\Modules\Crm\student_groups;


use App\Modules\Crm\student_groups\components\repositories\SpecialtiesRepositories;
use App\Modules\Crm\student_groups\components\repositories\StudentGroupRepositories;
use App\Modules\Crm\student_groups\controllers\SpecialtiesController;
use App\Modules\Crm\student_groups\controllers\StudentGroupsController;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;

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

    public static function controllers(): array
    {
        return [
            SpecialtiesController::class,
            StudentGroupsController::class,
        ];
    }

    public function requireModule(): bool
    {
        return true;
    }
}
