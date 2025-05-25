<?php
namespace App\Modules\Crm\backend_module;

use App\Modules\Crm\backend_module\repositories\CronRepository;
use App\Modules\Crm\backend_module\repositories\TaskRepository;
use App\Modules\Crm\backend_module\tasks\TestTask;
use App\Modules\Crm\schedule\operations\ScheduleApiOperation;
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
            TaskRepository::class,
            CronRepository::class
        ];
    }

    public static function operations(): array
    {
        return [
            ScheduleApiOperation::class
        ];
    }
    public static function runConfig()
    {
        Config::set('view.paths', array(__DIR__.'/views'));
    }

    public static function tasks(): array
    {
        return  [
            TestTask::class
        ];
    }

    public static function mangers(): array
    {
        return [];
    }

    public static function components(): array
    {
        return [];
    }

    public static function crons(): array
    {
        return [
        ];
    }
}
