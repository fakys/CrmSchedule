<?php
namespace App\Modules\Crm\holidays\model;

use App\Modules\Crm\holidays\exceptions\HolidayException;
use App\Src\BackendHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property array $holidays
 * @property bool $use_settings
 * @property int $priority_setting
 * @property bool $use_priority_setting
 * @property bool $replace_no_priority_setting
 */
class HolidaySetting extends Model implements InterfaceModel
{
    const MAIN_SETTING = 1;
    const DATE_SETTING = 2;
    protected $setting;

    public function fields(): array
    {
        return [
            'use_settings',
            'holidays',
            'use_priority_setting',
            'priority_setting',
            'replace_no_priority_setting'
        ];
    }

    public function rules(): array
    {
        return [
        ];
    }

    public function boolean(): array
    {
        return [
            'replace_no_priority_setting',
            'use_priority_setting'
        ];
    }

    public static function getSettingName(): string
    {
        return 'holiday_settings';
    }


    public function holidayValidate()
    {
        if ($this->use_settings && $this->holidays) {
            foreach ($this->holidays as $number=>$holiday) {
                if (empty($holiday['name']) && !$holiday['name']) {
                    throw new HolidayException("Введите название праздника в празднике №$number");
                }
                if(empty($holiday['period']) && !$holiday['period']) {
                    throw new HolidayException("Введите название праздника в празднике №$number");
                }
                if($holiday['week_days'] == 'false' && (empty($holiday['format']) || $holiday['format'] == 0)) {
                    throw new HolidayException("Выберете формат в празднике №$number");
                }

                $holiday_data[$number] = $holiday;
            }
        }
    }
}
