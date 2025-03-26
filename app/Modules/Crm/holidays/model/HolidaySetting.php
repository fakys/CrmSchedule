<?php
namespace App\Modules\Crm\holidays\model;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property array $holidays
 * @property bool $use_settings
 */
class HolidaySetting extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'use_settings',
            'holidays'
        ];
    }

    public function rules(): array
    {
        return [
            'holidays' => ['required', 'array'],
        ];
    }

    public function boolean(): array
    {
        return [];
    }

    public static function getSettingName(): string
    {
        return 'holiday_settings';
    }
}
