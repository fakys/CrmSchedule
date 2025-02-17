<?php
namespace App\Modules\Crm\schedule\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $number
 * @property string $full_name
 * @property string $description
 */
class ScheduleManagerModel extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'period',
            'groups',
            'specialties'
        ];
    }

    public function rules(): array
    {
        return [
            'period' => ['required', 'string'],
            'groups' => ['array'],
            'specialties' => ['array'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }
}
