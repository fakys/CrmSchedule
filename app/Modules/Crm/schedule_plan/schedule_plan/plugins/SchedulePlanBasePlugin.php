<?php
namespace App\Modules\Crm\schedule_plan\schedule_plan\plugins;

use App\Entity\SchedulePlanType;
use App\Entity\Semester;
use App\Entity\StudentGroup;
use App\Modules\Crm\schedule_plan\src\SchedulePlanEntity;
use App\Modules\Crm\schedule_plan\src\SchedulePlanUnit;
use App\Src\BackendHelper;
use App\Src\modules\plugins\AbstractPlugin;

/**
 * Плагин базового плана расписания
 * @property SchedulePlanType $plan_type
 * @property StudentGroup $group
 * @property Semester $semester
 * @property array $plan_schedule_repository
 * @property SchedulePlanEntity $schedule_plan
 */
class SchedulePlanBasePlugin extends AbstractPlugin
{

    public function pluginName()
    {
        return 'Schedule_plan_base_plugin';
    }

    public function Execute()
    {
        $this->init();
        $this->plan_schedule_repository = BackendHelper::getRepositories()
            ->getPlanScheduleByGroupFroManager(
                $this->group->id,
                $this->semester->id);

        /** Если расписание составлено, то строим юниты */
        if (empty($this->plan_schedule_repository)) {
            foreach ($this->plan_schedule_repository as $schedule_plan) {
                $this->createUnit(
                    $schedule_plan->time_start,
                    $schedule_plan->time_end,
                    $schedule_plan->subject_id,
                    $schedule_plan->teacher_id,
                    $schedule_plan->format_id,
                    $schedule_plan->schedule_description,
                    $schedule_plan->semester_id,
                    $schedule_plan->plan_type_id,
                    $schedule_plan->week_day,
                    $schedule_plan->week_number,
                    $schedule_plan->pair_id
                );
            }
        }
        $this->setResult($this->schedule_plan);
    }

    public function createUnit(
        $time_start,
        $time_end,
        $subject_id,
        $user_id,
        $format_pair_id,
        $description,
        $semester_id,
        $plan_type_id,
        $week_day,
        $week_number,
        $pair_id
    )
    {
        $unit = new SchedulePlanUnit();
        $unit->setTimeStart($time_start);
        $unit->setPairId($pair_id);
        $unit->setTimeEnd($time_end);
        $unit->setSubject($subject_id);
        $unit->setUser($user_id);
        $unit->setDescription($description);
        $unit->setFormatPair($format_pair_id);
        $unit->setSemesterId($semester_id);
        $unit->setPlanTypeId($plan_type_id);
        $unit->setWeekDay($week_day);
        $unit->setWeekNumber($week_number);
        $this->schedule_plan->addUnit($unit);
    }

    public function init()
    {
        if (!$this->schedule_plan) {
            $this->schedule_plan = new SchedulePlanEntity();
        }
        $this->plan_type = BackendHelper::getRepositories()->getSchedulePlanTypeById($this->context->getAttr('plan_type_id'));
        $this->group = BackendHelper::getRepositories()->getStudentGroupById($this->context->getAttr('group_id'));
        $this->semester = BackendHelper::getRepositories()->getSemesterById($this->context->getAttr('semester_id'));
    }
}
