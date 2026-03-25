<?php
namespace App\Modules\Crm\system_settings\components\settings;

use App\Src\modules\settings\AbstractSettingsComponent;

/**
 * @property $system_lang
 * @property $system_name
 * @property $db_tome_zone
 * @property $site_tome_zone
 */
class CrmSetting extends AbstractSettingsComponent
{
    const SETTING_NAME = 'crm_settings';

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

    public function getSystemLang()
    {
        return $this->system_lang;
    }

    public function setSystemLang($system_lang)
    {
        $this->system_lang = $system_lang;
    }

    public function getSystemName()
    {
        return $this->system_name;
    }

    public function setSystemName($system_name)
    {
        $this->system_name = $system_name;
    }

    public function getDbTomeZone()
    {
        return $this->db_tome_zone;
    }

    public function setDbTomeZone($db_tome_zone)
    {
        $this->db_tome_zone = $db_tome_zone;
    }

    public function getSiteTomeZone()
    {
        return $this->site_tome_zone;
    }
}
