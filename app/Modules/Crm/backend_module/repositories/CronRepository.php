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


    /**
     * Добавляет крон в БД
     * @return CronSchedule|null
     */
    public function addCronSchedule($data)
    {
        $cron = new CronSchedule();
        $cron->cron_name = $data['cron_name'];
        $cron->status = $data['status'];
        $cron->start_time = $data['time_create'];
        $cron->end_time = $data['time_end'];
        $cron->pid = $data['pid'];
        if ($cron->save()) {
            return $cron;
        }
    }

    /**
     * Обновляет cron по id
     * @param $id
     * @param $cron
     * @return CronSchedule|void
     */
    public function updateCronScheduleById($id, $cron)
    {
        /** @var CronSchedule $schedule */
        $schedule = CronSchedule::where(['id'=>$id])->first();
        if ($schedule) {
            $schedule->status = $cron['status'];
            $schedule->pid = $cron['pid'];
        }
        if ($schedule->save()) {
            return $schedule;
        }
    }

    /**
     * @param $id
     * @param $status
     * @return void
     */
    public function updateStatusCronSchedule($id, $status, $end_time)
    {
        $schedule = CronSchedule::where(['id'=>$id])->first();
        $schedule->status = $status;
        $schedule->end_time = $end_time;
        $schedule->save();
    }


    /**
     * Возвращает крон по id
     * @param $id
     * @return CronSchedule
     */
    public function getCronScheduleById($id)
    {
        return CronSchedule::where(['id'=>$id])->first();
    }

    public function getName(): string
    {
        return 'cron_repository';
    }
}
