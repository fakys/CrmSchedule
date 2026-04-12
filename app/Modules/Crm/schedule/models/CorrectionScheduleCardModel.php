<?php

namespace App\Modules\Crm\schedule\models;

use App\Modules\Crm\schedule\src\factories\CorrectionScheduleCardFactory;
use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
use Illuminate\Validation\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @property $id
 * @property $cardName
 * @property $numberPair
 * @property $groupId
 * @property $teacherId
 * @property $subjectId
 * @property $start
 * @property $end
 * @property $description
 * @property $formatId
 *
 */
class CorrectionScheduleCardModel extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'id',
            'cardName',
            'numberPair',
            'groupId',
            'teacherId',
            'subjectId',
            'start',
            'end',
            'description',
            'formatId',
        ];
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'cardName' => ['required', 'string'],
            'numberPair' => ['required', 'integer', 'exists:pair_numbers,number'],
            'groupId' => ['required', 'integer', 'exists:student_groups,id'],
            'teacherId' => ['nullable', 'integer', 'exists:users,id'],
            'subjectId' => ['nullable', 'integer', 'exists:subjects,id'],
            'start' => ['nullable'],
            'end' => ['nullable'],
            'description' => ['nullable'],
            'formatId' => ['nullable', 'integer', 'exists:format_lessons,id'],
        ];
    }

    public function toEntity()
    {
        return CorrectionScheduleCardFactory::createCorrectionCard($this->getData());
    }

    public function boolean(): array
    {
        return [];
    }
}
