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

    public function getActiveSystemSettings($name)
    {
        return SystemSetting::where([
            'name'=> $name,
            'active'=>true
            ])->orderBy('id', 'desc')->first();
    }

    public function getLastSystemSettings($name)
    {
        return SystemSetting::where([
            'name'=> $name
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

    /**
     * Создает настройку
     * @param $data
     * @return bool
     */
    public static function setSystemSettings($data)
    {
        $settings = new SystemSetting();
        $settings->name = $data['name'];
        $settings->active = $data['active'];
        if (is_array($data['settings'])) {
            $settings->settings = json_encode($data['settings']);
        } else {
            $settings->settings = $data['settings'];
        }
        $settings->create_user_id = $data['create_user_id'];
        if ($settings->save()) {
            return true;
        }
        return false;
    }
}
