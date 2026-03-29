<?php
namespace App\Modules\Crm\schedule_plan\schedule_plan;

use App\Modules\Crm\schedule_plan\schedule_plan\plugins\SchedulePlanBasePlugin;
use App\Src\modules\plugins\mangers\AbstractManger;

class SchedulePlanManager extends AbstractManger  {

    public static function mangerName()
    {
        return 'schedule_plan_manager';
    }

    public function plugins()
    {
        return [
            SchedulePlanBasePlugin::class
        ];
    }

    public function getName():string
    {
        return 'schedule_plan_manager';
    }
}
