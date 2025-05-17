<?php
namespace App\Modules\Crm\backend_module\repositories;


use App\Entity\CronSchedule;
use App\Entity\ScheduleTask;
use App\Src\modules\repository\AbstractRepositories;;

class CronRepository extends AbstractRepositories
{
    /**
     * Возвращает последний запуск крона
     * @param $cronName
     * @return CronSchedule
     */
    public function getLastCronByName($cronName)
    {
        return CronSchedule::where(['cron_name'=>$cronName])->first();
    }

    public function getName(): string
    {
        return 'cron_repository';
    }
}
