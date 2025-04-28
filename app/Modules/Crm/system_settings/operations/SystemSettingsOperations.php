<?php
namespace App\Modules\Crm\system_settings\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class SystemSettingsOperations extends AbstractOperation{

    public function createSystemSettings($data)
    {
        $system_settings = BackendHelper::getRepositories()
            ->getSystemSettings(['name'=>$data['name'], 'active'=>true]);
        if($system_settings->toArray()){
            foreach ($system_settings as $setting){
                $setting->active = false;
                $setting->save();
            }
        }
        return BackendHelper::getRepositories()->setSystemSettings($data);
    }

    public function getCurrentSystemSettings($name)
    {
        $setting = BackendHelper::getRepositories()->getActiveSystemSettings($name);
        if($setting){
            return $setting;
        }
        $setting = BackendHelper::getRepositories()->getLastSystemSettings($name);
        if($setting){
            return BackendHelper::getRepositories()->saveActiveSystemSettings($setting);
        }
        return null;
    }

    public function getName(): string
    {
        return 'system_settings_operations';
    }
}
