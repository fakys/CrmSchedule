<?php
namespace App\Modules\Crm\schedule_plan;


use App\Modules\Crm\schedule_plan\components\operation\SchedulePlan;
use App\Modules\Crm\schedule_plan\components\operation\SchedulePlanSave;
use App\Modules\Crm\schedule_plan\components\operation\SchedulePlanType;
use App\Modules\Crm\schedule_plan\components\operation\ValidateSchedulePlan;
use App\Modules\Crm\schedule_plan\components\parse_schedule\ParseScheduleManager;
use App\Modules\Crm\schedule_plan\components\parse_schedule\plugins\BaseScheduleParsePlugin;
use App\Modules\Crm\schedule_plan\components\repositories\SchedulePlanRepository;
use App\Modules\Crm\schedule_plan\components\repositories\SchedulePlanTypeRepository;
use App\Modules\Crm\schedule_plan\controllers\SchedulePlanController;
use App\Modules\Crm\schedule_plan\controllers\SchedulePlanTypeController;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'schedule_plan';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль плана расписания';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за план расписания и его настройку';
    }

    public static function repositories(): array
    {
        return [
            SchedulePlanTypeRepository::class,
            SchedulePlanRepository::class,
        ];
    }

    public static function operations(): array
    {
        return [
            SchedulePlanType::class,
            SchedulePlan::class,
            SchedulePlanSave::class,
            ValidateSchedulePlan::class,
        ];
    }

    public static function tasks(): array
    {
        return  [];
    }

    public static function mangers(): array
    {
        return [
            ParseScheduleManager::class,
            BaseScheduleParsePlugin::class,
        ];
    }

    public static function controllers(): array
    {
        return [
            SchedulePlanController::class,
            SchedulePlanTypeController::class
        ];
    }

    public function requireModule(): bool
    {
        return true;
    }
}
