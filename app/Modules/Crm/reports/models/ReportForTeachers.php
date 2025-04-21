<?php
namespace App\Modules\Crm\reports\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class ReportForTeachers extends Model implements InterfaceModel
{

    const REPORT_FOR_GROUP = 'report_for_teachers';

    public function fields(): array
    {
        return [
            'period',
            'teachers',
        ];
    }

    public function rules(): array
    {
        return [
            'period' => ['required'],
            'teachers' => [],
        ];
    }

    public function boolean(): array
    {
        return [];
    }
}
