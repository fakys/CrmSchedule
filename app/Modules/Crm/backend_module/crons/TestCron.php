<?php
namespace App\Modules\Crm\backend_module\crons;


use App\Src\modules\crons_schedule\AbstractCronSchedule;

class TestCron extends AbstractCronSchedule
{

    public function getName(): string
    {
        return 'test_cron';
    }

    public function Execute($args = []): bool
    {
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
