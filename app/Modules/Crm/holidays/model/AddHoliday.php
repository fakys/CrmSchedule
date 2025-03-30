<?php
namespace App\Modules\Crm\holidays\model;

use App\Src\BackendHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $name
 * @property string $date_start
 * @property string $date_end
 * @property string $period
 * @property bool $week_days
 * @property int $format
 * @property string $description
 */
class AddHoliday extends Model implements InterfaceModel
{
    public function fields(): array
    {
        return [
            'name',
            'period',
            'week_days',
            'format',
            'description'
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'period' => ['string', 'required'],
            'week_days' => ['bool', 'required'],
            'format' => ['string', 'required'],
        ];
    }

    public function pacePeriod()
    {
        $period_arr = BackendHelper::getOperations()->pacePeriod($this->period);
        $this->date_start = $period_arr[0]->format('Y-m-d');
        $this->date_end = $period_arr[1]->format('Y-m-d');
        return $this;
    }

    public function boolean(): array
    {
        return [
            'week_days'
        ];
    }
}
