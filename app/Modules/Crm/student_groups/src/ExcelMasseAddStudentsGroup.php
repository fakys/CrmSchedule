<?php

namespace App\Modules\Crm\student_groups\src;

use App\Entity\SchedulePlanType;
use App\Entity\StudentGroup;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Modules\Crm\users_interface\exceptions\MasseAddTeachersExceptions;
use App\Src\BackendHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Cell;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExcelMasseAddStudentsGroup implements FromArray, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Номер группы', 'Название группы']
        ];
    }
}
