<?php
namespace App\Modules\Crm\schedule\schedule_manger;

use App\Modules\Crm\schedule\schedule_manger\plugins\BaseSchedulePlugin;
use App\Modules\Crm\schedule\schedule_manger\plugins\HolidaysPlugin;
use App\Modules\Crm\schedule\schedule_manger\plugins\SchedulePlugin;
use App\Modules\Crm\schedule\schedule_manger\plugins\WeekendsPlugin;
use App\Src\modules\plugins\mangers\AbstractManger;

/** Менеджер возвращает расписание */
class ScheduleManger extends AbstractManger{

    public static function mangerName()
    {
        return 'schedule_manger';
    }

    public function plugins()
    {
        return [
            BaseSchedulePlugin::class,
//            SchedulePlugin::class,
            WeekendsPlugin::class,
            HolidaysPlugin::class,
        ];
    }
}
