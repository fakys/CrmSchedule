<?php
namespace App\Modules\Crm\reports\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class ReportForGroupModel extends Model implements InterfaceModel
{

    const REPORT_FOR_GROUP = 'report_for_group';

    public function fields(): array
    {
        return [
            'period',
            'students_group',
            'specialties',
            'semesters'
        ];
    }

    public function rules(): array
    {
        return [
            'period' => ['required'],
            'students_group' => [],
            'specialties' => [],
            'semesters' => []
        ];
    }

    public function boolean(): array
    {
        return [];
    }
}
