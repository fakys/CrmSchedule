<?php
namespace App\Modules\Crm\modules_settings\repositories;

use App\Entity\StatusModules;
use App\Entity\UserInfo;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;

class ModulesRepository extends AbstractRepositories {
    public function getFullModuleSettings()
    {
        return StatusModules::all();
    }

    public function createStatusModules($arg)
    {
        return StatusModules::create($arg);
    }
    public function getModules($arg)
    {
        return StatusModules::where($arg)->get();
    }

    public function updateStatusModules($name, $status)
    {
        $module = StatusModules::where(['name'=>$name])->get()->first();
        $module->active = $status;
        return $module->save();
    }

    /**
     * @return StatusModules[]
     */
    public function getAllActiveModules()
    {
        return StatusModules::where(['active'=>true])->get();
    }

    public function clearModules()
    {
        StatusModules::truncate();
    }

    public function getName(): string
    {
        return 'modules_repository';
    }
}
