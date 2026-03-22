<?php

namespace App\Modules\Crm\modules_settings\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;

class SystemSettingsBundle extends AbstractAssets
{
    public function headerFiles(): array
    {
        return [];
    }

    public function bodyFiles(): array
    {
        return [
            'app/Modules/Crm/modules_settings/resources/js/modules_settings.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class,
        ];
    }
}
