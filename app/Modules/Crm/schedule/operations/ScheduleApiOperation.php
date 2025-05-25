<?php
namespace App\Modules\Crm\schedule\operations;

use App\Modules\Crm\schedule\src\schedule_manager\return_data_schedule\ScheduleManagerReturnDataApi;
use App\Modules\Crm\schedule\src\schedule_manager\Schedule;
use App\Modules\RestApi\schedule_api\exceptions\ApiException;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class ScheduleApiOperation extends AbstractOperation{

    public function getActualScheduleByGroup($group_name)
    {
        $group = BackendHelper::getRepositories()->getStudentGroupByName($group_name);
        if ($group) {
            $date_start = new \DateTime();
            $date_start->modify('this week');
            $date_end = new \DateTime();
            $date_end->modify('this week +6 days');

            $manager = BackendHelper::getManager('schedule_manger');
            $manager->setAttr(['search_data'=>['date_start'=> $date_start, 'date_end'=> $date_end, 'groups' => [$group[0]->id]]]);
            $manager->Execute();
            return (new ScheduleManagerReturnDataApi($manager->getResult()))->getSchedule();
        }
        throw new ApiException($group_name);
    }

    public function getActualScheduleByTeacherFio($fio)
    {
        $user = BackendHelper::getRepositories()->getFullUsersInfoSearch(['fio'=>$fio]);
        if ($user) {
            $user = $user[0];
            $date_start = new \DateTime();
            $date_start->modify('this week');
            $date_end = new \DateTime();
            $date_end->modify('this week +6 days');

            $manager = BackendHelper::getManager('schedule_manger');
            $manager->setAttr(['search_data'=>['date_start'=> $date_start, 'date_end'=> $date_end]]);
            $manager->Execute();
            /** @var Schedule $schedule */
            $schedule = $manager->getResult();
            $data = [];
            foreach ($schedule->getScheduleUnits() as $unit) {
                if ($unit->getUser() == $user->id) {
                    $data[] = $unit;
                } elseif ($unit->isEmpty()) {
                    $data[] = $unit;
                }
            }
            return (new ScheduleManagerReturnDataApi($data))->getSchedule();
        }
        throw new ApiException($fio);
    }
    public function getName(): string
    {
        return 'schedule_api_operation';
    }
}
