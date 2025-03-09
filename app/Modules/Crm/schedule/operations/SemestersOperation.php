<?php
namespace App\Modules\Crm\schedule\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;

class SemestersOperation extends Operation{

    /** Возвращает семестры для акшена */
    public function getSemesters()
    {
        $semesters = BackendHelper::getRepositories()->getAllSemesters();
        $data = [];
        foreach ($semesters as $semester) {
            $data["$semester->year_start-$semester->year_end"][] = $semester;
        }
        return $data;
    }
}
