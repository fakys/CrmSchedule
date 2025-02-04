<?php
namespace App\Modules\Crm\lessons\repositories;

use App\Entity\Subject;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class SubjectsRepository extends Repository{

    /**
     * Создает предмет
     * @param $name
     * @param $full_name
     * @param $description
     * @return Subject|null
     */
    public function createSubject($name, $full_name, $description = '')
    {
        $subject = new Subject();
        $subject->name = $name;
        $subject->full_name = $full_name;
        $subject->description = $description;

        if($subject->save()){
            return $subject;
        }
        return null;
    }

    /**
     * Возвращает предметы для таблицы
     * @return array
     */
    public function getSubjectInfo()
    {
        return DB::select("SELECT id, name, full_name, description, created_at FROM subjects ORDER BY id DESC");
    }
}
