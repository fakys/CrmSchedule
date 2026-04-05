<?php

namespace App\Modules\Crm\schedule_plan\models;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
use Illuminate\Validation\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @property $cardId
 * @property $cardName
 * @property $numberPair
 * @property $weekDay
 * @property $weekNumber
 * @property $groupId
 * @property $teacherId
 * @property $subjectId
 * @property $timeStart
 * @property $timeEnd
 * @property $description
 * @property $planTypeId
 * @property $formatId
 * @property $semesterId
 *
 */
class ScheduleCardModel extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'cardId',
            'cardName',
            'numberPair',
            'weekDay',
            'weekNumber',
            'groupId',
            'teacherId',
            'subjectId',
            'timeStart',
            'timeEnd',
            'description',
            'planTypeId',
            'formatId',
            'semesterId',
        ];
    }

    public function rules(): array
    {
        return [
            'cardId' => ['required', 'integer'],
            'cardName' => ['required', 'string'],
            'numberPair' => ['required', 'integer', 'exists:pair_numbers,number'],
            'weekDay' => ['required', 'integer', 'min:0', 'max:6'],
            'weekNumber' => ['required', 'integer'],
            'groupId' => ['required', 'integer', 'exists:student_groups,id'],
            'teacherId' => ['nullable', 'integer', 'exists:users,id'],
            'subjectId' => ['nullable', 'integer', 'exists:subjects,id'],
            'timeStart' => ['nullable'],
            'timeEnd' => ['nullable'],
            'description' => ['nullable'],
            'planTypeId' => ['required', 'integer', 'exists:schedule_plan_type,id'],
            'formatId' => ['nullable', 'integer', 'exists:format_lessons,id'],
            'semesterId' => ['required', 'integer', 'exists:semesters,id'],
        ];
    }

    public function toEntity()
    {
        return BackendHelper::getOperations()->convertDataToCardEntity($this->getData());
    }

    public function boolean(): array
    {
        return [];
    }
}
