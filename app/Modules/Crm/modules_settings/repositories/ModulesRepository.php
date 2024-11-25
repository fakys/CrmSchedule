<?php
namespace App\Modules\Crm\modules_settings\repositories;

use App\Entity\StatusModules;
use App\Entity\UserInfo;
use App\Src\modules\repository\Repository;

class ModulesRepository extends Repository {
    public function getFullModuleSettings()
    {
        return StatusModules::all();
    }

    public function createStatusModules($arg)
    {
        return StatusModules::create($arg[0]);
    }
    public function getModules($arg)
    {
        return StatusModules::where($arg[0])->get();
    }

    public function updateStatusModules(array $data)
    {
        $name = $data[0]['name'];
        $status = $data[0]['status'];
        $module = StatusModules::where(['name'=>$name])->get()->first();
        $module->active = $status;
        return $module->save();
    }
}
