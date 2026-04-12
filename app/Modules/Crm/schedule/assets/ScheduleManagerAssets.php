<?php
namespace App\Modules\Crm\schedule\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;

class ScheduleManagerAssets extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            'resources/plugins/fullcalendar/main.css',
            'app/Modules/Crm/schedule/resources/css/schedule_style.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'resources/plugins/js/jquery-ui.min.js',
            'app/Modules/Crm/schedule/resources/js/schedule_manager.js',
            'resources/plugins/fullcalendar/main.min.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
