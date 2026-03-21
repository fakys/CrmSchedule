<?php
namespace App\Modules\Crm\schedule\schedule_manger\plugins;

use App\Modules\Crm\schedule\schedule_manger\plugins\abstracts\AbstractSchedulePlugin;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;

/**
 * Плагин проставляющий выходные
 */
class WeekendsPlugin extends AbstractSchedulePlugin
{
    public function getTag()
    {
        return 'schedule_manger';
    }
    public function getName(): string
    {
        return 'weekends_plugin';
    }

    public function index()
    {
        return 2;
    }

    public function Execute()
    {
        $settings = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName());
        $type_weeks = $settings->type_weeks;

        if ($this->getSchedule()->getScheduleUnits()) {
            /** Устанавливаем выходные */
            foreach ($this->getSchedule()->getScheduleUnits() as $schedule) {
                $plan_type = $schedule->getSchedulePlanType();
                if ($plan_type->plan_type_data) {
                    $week_ends = json_decode($plan_type->plan_type_data, 1)['weeks'][$schedule->getWeekNumber()]['week_end'];
                    $schedule->setWeekEnd($week_ends[$schedule->getWeekDay()] == 'true');
                } else {
                    if ($type_weeks == ScheduleSetting::FIVE_DAY) {
                        if ($schedule->getDate()->format('w') == 6 || $schedule->getDate()->format('w') == 0) {
                            $schedule->setWeekEnd(true);
                        }
                    } else {
                        if ($schedule->getDate()->format('w') == 0) {
                            $schedule->setWeekEnd(true);
                        }
                    }
                }

            }
        }
    }
}
