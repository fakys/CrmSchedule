<?php

namespace App\Modules\Crm\schedule_plan\models;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
use Illuminate\Validation\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @property int $plan_type
 * @property int $semester
 * @property array $groups
 */
class SchedulePlanFileModel extends Model implements InterfaceModel
{


    public function fields(): array
    {
        return [
            'semester',
            'groups',
            'plan_type',
        ];
    }

    public function rules(): array
    {
        return [
            'semester' => ['required'],
            'groups' => ['required'],
            'plan_type' => ['required'],
        ];
    }

    public function boolean(): array
    {
        return [

        ];
    }
}
