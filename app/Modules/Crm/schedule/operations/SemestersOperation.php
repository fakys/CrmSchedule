<?php
namespace App\Modules\Crm\schedule\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class SemestersOperation extends AbstractOperation{

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

    public function getName(): string
    {
        return 'semesters_operation';
    }
}
