<?php
namespace App\Modules\Crm\schedule_plan\src\factories;

use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;

class SchedulePlanReturnDataFactory {
    public static function createCashSchedulePlanReturnData(array $data): SchedulePlanReturnData
    {
        return new SchedulePlanReturnData(
            $data['semester'],
            $data['groups'],
            $data['specialties'],
            $data['plan_type'],
            $data['schedule_data'] ?? [],
            $data['error_message'] ?? null
        );
    }
}
