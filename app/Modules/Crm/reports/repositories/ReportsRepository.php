<?php
namespace App\Modules\Crm\reports\repositories;

use App\Entity\ScheduleTask;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class ReportsRepository extends Repository {

    /**
     * роверяет есть ли у пользователя активные таски
     * @param $task_name
     * @param $user_name
     * @return array
     */
    public function hasActiveTask($task_name, $user_name)
    {
        $sql = "select * from schedule_task
         where task_name = :task_name and args->>'userName'= '$user_name' and status in (:status_active, :status_pending)";

        return DB::select(
            $sql,
            [
                'task_name' => $task_name,  'status_active' => ScheduleTask::ACTIVE_STATUS,
                'status_pending' => ScheduleTask::PENDING_STATUS
            ]
        );
    }
}
