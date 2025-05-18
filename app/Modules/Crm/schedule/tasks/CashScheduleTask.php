<?php
namespace App\Modules\Crm\schedule\tasks;

use App\Entity\User;
use App\Exports\ExportExcel;
use App\Src\BackendHelper;
use App\Src\modules\task\AbstractTask;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use function Symfony\Component\Translation\t;

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
