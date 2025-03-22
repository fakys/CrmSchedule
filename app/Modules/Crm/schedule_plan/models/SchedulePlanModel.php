<?php

namespace App\Modules\Crm\schedule_plan\models;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property array $schedule_data
 * @property int $group_id
 * @property int $type_id
 * @property int $semester_id
 */
class SchedulePlanModel extends Model implements InterfaceModel
{

    private $users;
    private $subjects;
    private $pair_number;
    private $pair_format;

    public function fields(): array
    {
        return [
            'schedule_data',
            'group_id',
            'type_id',
            'semester_id'
        ];
    }

    public function rules(): array
    {
        return [
            'schedule_data' => ['required'],
            'group_id' => ['required', 'integer'],
            'semester_id' => ['required', 'integer'],
        ];
    }

    public function boolean(): array
    {
        return [

        ];
    }

    /**
     * @throws SchedulePlanAddException
     */
    public function validatePlan()
    {
        $this->validateParam();
        foreach ($this->schedule_data as $number_week=>$plan) {
            foreach ($plan as $day_number => $day_week) {
                foreach ($day_week as $number => $pair) {
                    if (
                        !$pair["subject_id"] &&
                        !$pair["user_id"] &&
                        !$pair["format_lesson_id"] &&
                        !$pair["time_end"] &&
                        !$pair["time_start"]
                    ){
                        unset($this->data['schedule_data'][$number_week][$day_number][$number]);
                    }elseif (
                        $pair["subject_id"] &&
                        $pair["user_id"] &&
                        $pair["format_lesson_id"] &&
                        (
                            !in_array($number, $this->pair_number) ||
                            !in_array($pair["subject_id"], $this->subjects) ||
                            !in_array($pair["user_id"], $this->users) ||
                            !in_array($pair["format_lesson_id"], $this->pair_format)
                        )
                    ) {
                        throw new SchedulePlanAddException('Ошибка добавления');
                    }
                }
            }
        }

        return true;
    }

    private function validateParam()
    {
        if (!$this->schedule_data) {
            throw new SchedulePlanAddException('План пуст');
        }

        if (!BackendHelper::getRepositories()->getStudentGroupById($this->group_id)) {
            throw new SchedulePlanAddException('Группа не верна');
        }

        if (!BackendHelper::getRepositories()->getSemesterById($this->semester_id)) {
            throw new SchedulePlanAddException('Семестр не верен');
        }
        $this->init();
    }

    private function init()
    {
        $this->users = ArrayHelper::getColumn(BackendHelper::getRepositories()->getUserList([]), 'id');
        $this->pair_format = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullFormatLessons(), 'id');
        $this->pair_number = ArrayHelper::getColumn(BackendHelper::getRepositories()->getNumberPair(), 'id');
        $this->subjects = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullSubject(), 'id');
    }
}
