<?php
namespace App\Modules\Crm\system_settings\repositories;

use App\Entity\SystemSetting;
use App\Src\modules\repository\Repository;

class SystemSettingRepository extends Repository{
    public function getSystemSettingsById($id)
    {
        return SystemSetting::find($id);
    }

    public function getSystemSettings($data)
    {
        return SystemSetting::where($data)->get();
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

    public function saveActiveSystemSettings($setting)
    {
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
        return SystemSetting::create($data);
    }
}
