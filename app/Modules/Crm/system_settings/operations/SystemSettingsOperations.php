<?php
namespace App\Modules\Crm\system_settings\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class SystemSettingsOperations extends Operation{
    public function createSystemSettings($name)
    {
        $system_settings = BackendHelper::getRepositories()
            ->getSystemSettings(['name'=>$name, 'active'=>true]);
        if($system_settings->toArray()){
            foreach ($system_settings as $setting){
                $setting->active = false;
                $setting->save();
            }
        }
        return BackendHelper::getRepositories()->setSystemSettings($name);
    }

    public function getСurrentSystemSettings($name)
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
}
