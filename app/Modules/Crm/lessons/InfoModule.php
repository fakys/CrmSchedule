<?php
namespace App\Modules\Crm\lessons;


use App\Modules\Crm\lessons\operations\SubjectOperation;
use App\Modules\Crm\lessons\repositories\LessonsRepository;
use App\Modules\Crm\lessons\repositories\SubjectsRepository;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'lessons';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль предметов(уроков)';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за предметы и их настройку';
    }

    public static function repositories(): array
    {
        return [
            SubjectsRepository::class,
            LessonsRepository::class
        ];
    }

    public static function operations(): array
    {
        return [
            SubjectOperation::class
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
