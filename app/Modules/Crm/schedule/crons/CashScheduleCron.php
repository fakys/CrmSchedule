<?php
namespace App\Modules\Crm\schedule\crons;


use App\Src\BackendHelper;
use App\Src\modules\crons_schedule\AbstractCronSchedule;

/**
 * Крон кеширует расписание
 */
class CashScheduleCron extends AbstractCronSchedule
{

    public function getName(): string
    {
        return 'cash_schedule_cron';
    }

    public function Execute($args = []): bool
    {
        BackendHelper::getOperations()->cashSchedule();
        return true;
    }

    public static function TimeZone(): string
    {
        return '';
    }

    public function timeStart(): string
    {
        return '* * * * *';
    }
}
