<?php
namespace App\Modules\Crm\schedule\schedule_manger;

use App\Modules\Crm\schedule\schedule_manger\plugins\TestPlugin;
use App\Modules\Crm\schedule\schedule_manger\plugins\TestPluginOne;
use App\Src\modules\plugins\mangers\AbstractManger;

class ScheduleManger extends AbstractManger{

    public static function mangerName()
    {
        return 'schedule_manger';
    }

    public function plugins()
    {
        return [
        ];
    }
}
