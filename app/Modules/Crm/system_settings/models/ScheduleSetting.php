<?php
namespace App\Modules\Crm\system_settings\models;

use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class ScheduleSetting extends Model implements InterfaceModel
{
    const SIX_DAY = 1;
    const FIVE_DAY = 2;

    public function fields(): array
    {
        return [
            'users_groups',
            'type_weeks',
            'count_minutes_for_cash',
            'cash_schedule'
        ];
    }

    public function rules(): array
    {
        return [
            'users_groups'=>['required', 'array'],
            'type_weeks' => ['required', 'integer'],
            'count_minutes_for_cash' => ['integer'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

    public static function getSettingName(): string
    {
        return 'schedule_settings';
    }
}
