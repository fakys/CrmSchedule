<?php

namespace App\Modules\Crm\student_groups\components\operations;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\schedule_plan\src\ExcelPlanSchedule;
use App\Modules\Crm\student_groups\src\MassAddStudentsGroupEntity;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use App\Src\redis\RedisManager;
use Illuminate\Support\Facades\DB;

class StudentsGroupOperation extends AbstractOperation
{

    /**
     * Массовое добавление групп студентов
     * @param MassAddStudentsGroupEntity[] $data
     * @param $speciality
     * @return void
     */
    public function massAddStudentsGroup(array $data, $speciality_id)
    {
        DB::beginTransaction();
        try {
            foreach ($data as $group) {
                BackendHelper::getRepositories()->createStudentGroup($group->getNumber(), $group->getName(), $speciality_id);
            }
        } catch (\Throwable $throwable) {
            DB::rollBack();
            throw $throwable;
        }
        DB::commit();
    }

    public function getName(): string
    {
        return 'students_group_operation';
    }
}
