<?php

namespace App\Modules\Crm\schedule_plan\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $data
 * @property string $name
 */
class SchedulePlanTypeModel extends Model implements InterfaceModel
{
    const WEEK_DAYS = [
        1=>'Пн',
        2=>'Вт',
        3=>'Ср',
        4=>'Чт',
        5=>'Пт',
        6=>'Сб',
        7=>'Вс',
    ];
    public function fields(): array
    {
        return [
            'name',
            'data'
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'data' => ['required'],
        ];
    }

    public function boolean(): array
    {
        return [

        ];
    }
}
