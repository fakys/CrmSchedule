<?php
namespace App\Modules\Crm\schedule\components\tasks;

use App\Src\BackendHelper;
use App\Src\modules\task\AbstractTask;

class CashScheduleTask extends AbstractTask
{

    const TASK_NAME = 'cash_schedule_task';
    public static function taskName(): string
    {
        return self::TASK_NAME;
    }

    public function Execute($args = []): bool
    {
        BackendHelper::getOperations()->deleteCashSchedule();
        BackendHelper::getOperations()->cashSchedule();
        return true;
    }

    public static function RepeatInterval()
    {
        return [];
    }

    public static function TimeZone(): string
    {
        return '';
    }

    public function getName(): string
    {
        return self::TASK_NAME;
    }
}
