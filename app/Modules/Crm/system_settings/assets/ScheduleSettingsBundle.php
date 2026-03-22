<?php

namespace App\Modules\Crm\system_settings\assets;


use App\Assets\LayoutBundle;
use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class ScheduleSettingsBundle implements AssetBundleInterface
{

    public function headerFiles(): array
    {
        return [];
    }

    public function bodyFiles(): array
    {
        return ['app/Modules/Crm/system_settings/resources/js/schedule_settings.js'];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
