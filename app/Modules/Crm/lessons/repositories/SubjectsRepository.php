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

    /**
     * Возвращает все предметы
     * @return Subject[]
     */
    public function getFullSubject()
    {
        return Subject::all();
    }

    /**
     * Возвращает предметы для таблицы с поиском
     * @param $searchData
     * @return array
     */
    public function getSearchSubjectInfo($searchData)
    {
        $sql = "SELECT id, name, full_name, description, created_at
                FROM subjects ";
        $arr_data = [];

        if ($searchData['name'] || $searchData['full_name']) {
            $sql .= " WHERE";
        }

        if ($searchData['name']) {
            $sql .= " name = :name";
            $arr_data = [':name' => $searchData['name']];
        }

        if ($searchData['full_name']) {
            $sql .= " full_name = :full_name";
            $arr_data = [':full_name' => $searchData['full_name']];
        }

        $sql .= " ORDER BY id DESC";

        return DB::select($sql, $arr_data);
    }

    /**
     * Возвращает предмет по id
     * @param $id
     * @return mixed
     */
    public function getSubjectById($id)
    {
        return Subject::where(['id'=>$id])->first();
    }

    /**
     * Обновляет предмет по id и полю
     * @param $id
     * @param $field
     * @param $value
     * @return bool
     */
    public function updateSubjectField($id, $field, $value)
    {
        $subject = Subject::where(['id'=>$id])->first();
        if ($subject){
            $subject->name = $value;
        }

        return $subject->save();
    }
}
