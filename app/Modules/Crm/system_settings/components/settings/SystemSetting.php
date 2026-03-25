<?php

namespace App\Modules\Crm\system_settings\components\settings;

use App\Src\modules\settings\AbstractSettingsComponent;

/**
 * @property $system_lang
 * @property $system_name
 * @property $db_tome_zone
 * @property $site_tome_zone
 */
class SystemSetting extends AbstractSettingsComponent
{
    const SETTING_NAME = 'system_settings';

    public function getName(): string
    {
        return self::SETTING_NAME;
    }

    public function getDefaultSettings(): array
    {
        return [
            'system_name' => env('APP_NAME'),
            'system_lang' => 1,
            'db_tome_zone' => 'Europe/Moscow',
            'site_tome_zone' => 'Europe/Moscow',
        ];
    }

    public function getSystemLang(): string
    {
        return $this->system_lang;
    }

    public function getSystemName(): string
    {
        return $this->system_name;
    }

    public function getDbTomeZone(): string
    {
        return $this->db_tome_zone;
    }

    public function getSiteTomeZone(): string
    {
        return $this->site_tome_zone;
    }
}
