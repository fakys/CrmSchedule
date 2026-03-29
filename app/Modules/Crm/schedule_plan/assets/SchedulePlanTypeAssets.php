<?php
namespace App\Modules\Crm\schedule_plan\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;

class SchedulePlanTypeAssets extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            'app/Modules/Crm/schedule_plan/resources/css/schedule_plan.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'app/Modules/Crm/schedule_plan/resources/js/type_plan_schedule.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
