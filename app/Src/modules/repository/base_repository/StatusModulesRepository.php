<?php

namespace App\Src\modules\repository\base_repository;

use App\Entity\StatusModules;

class StatusModulesRepository
{
    public static function getStatusModuleByName($name): ?StatusModules
    {
        return StatusModules::where(['name' => $name])->first();
    }

    public static function createStatusModule($name, $active)
    {
        $status = new StatusModules();
        $status->name = $name;
        $status->active = $active;
        $status->save();
        return $status;
    }
}
