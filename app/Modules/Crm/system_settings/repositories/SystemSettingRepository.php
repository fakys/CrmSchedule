<?php
namespace App\Modules\Crm\system_settings\repositories;

use App\Entity\SystemSetting;
use App\Src\modules\repository\Repository;

class SystemSettingRepository extends Repository{
    public function getSystemSettingsById($data)
    {
        return SystemSetting::find($data['id']);
    }

    public function getSystemSettings($data)
    {
        return SystemSetting::where($data[0])->get();
    }

    public function getActiveSystemSettings()
    {
        return SystemSetting::where([
            'name'=> \App\Modules\Crm\system_settings\models\SystemSetting::getSettingName(),
            'active'=>true
            ])->orderBy('id', 'desc')->first();
    }

    public function getLastSystemSettings()
    {
        return SystemSetting::where([
            'name'=> \App\Modules\Crm\system_settings\models\SystemSetting::getSettingName()
        ])->orderBy('id', 'desc')->first();
    }

    public function saveActiveSystemSettings(array $setting)
    {
        $setting = $setting[0];
        $setting->active = true;
        $setting->save();
        return $setting;
    }

    public function getAllSystemSettings()
    {
        return SystemSetting::all();
    }

    public static function setSystemSettings($data)
    {
        return SystemSetting::create($data[0]);
    }
}
