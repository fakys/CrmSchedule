<?php
namespace App\Modules\Crm\system_settings\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class SystemSettingsOperations extends Operation{
    public function createSystemSettings(array $data)
    {
        $data = $data[0];
        $system_settings = BackendHelper::getRepositories()
            ->getSystemSettings(['name'=>$data['name'], 'active'=>true]);
        if($system_settings->toArray()){
            foreach ($system_settings as $setting){
                $setting->active = false;
                $setting->save();
            }
        }
        return BackendHelper::getRepositories()->setSystemSettings( $data);
    }

    public function getСurrentSystemSettings()
    {
        $setting = BackendHelper::getRepositories()->getActiveSystemSettings();
        if($setting){
            return $setting;
        }
        $setting = BackendHelper::getRepositories()->getLastSystemSettings();
        if($setting){
            return BackendHelper::getRepositories()->saveActiveSystemSettings($setting);
        }
        return null;
    }
}
