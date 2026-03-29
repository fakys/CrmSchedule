<?php
namespace App\Modules\Crm\schedule\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;

class ScheduleManagerAssets extends AbstractAssets
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
            'app/Modules/Crm/schedule/resources/js/schedule_manager.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
