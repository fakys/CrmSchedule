<?php
namespace App\Modules\Crm\student_groups\repositories;

use App\Entity\StudentGroup;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class StudentGroupRepositories extends AbstractRepositories
{
    /**
     * @param array $data
     * @return StudentGroup|null
     */
    public function createStudentGroup($number, $name, $specialty_id = '')
    {
        $group = new StudentGroup();
        $group->name = $name;
        $group->specialty_id = $specialty_id;
        $group->number = $number;

        if($group->save()){
            return $group;
        }
        return null;
    }

    /**
     * Получает группу студентов то id
     * @param $id
     * @return StudentGroup
     */
    public function getStudentGroupById($id)
    {
        return StudentGroup::where(['id' => $id])->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getStudentGroupByQuery($fields, $array)
    {
        return StudentGroup::whereIn($fields, $array)->get();
    }

    /**
     * Получает первую группу студентов то названию
     * @param $name
     * @return array
     */
    public function getStudentGroupByName($name)
    {
        $groups = DB::select(
            "SELECT sg.id, sg.name, sg.number, specialties.name as specialties, specialties.description as specialty_description
        FROM student_groups sg left join specialties on specialties.id = sg.specialty_id where sg.name = :name", [':name' => $name]
        );

        return $groups;
    }

    /**
     * Возвращает все группы со специальностями
     * @return array
     */
    public function getStudentGroupsInfo()
    {
        $groups = DB::select(
            "SELECT sg.id, sg.name, sg.number, specialties.name as specialties, specialties.description as specialty_description
        FROM student_groups sg left join specialties on specialties.id = sg.specialty_id"
        );

        return $groups;
    }

    /**
     * Возвращает все группы студентов
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFullStudentGroups()
    {
        return StudentGroup::all();
    }

    /**
     * Поиск групп студентов
     * @return array
     */
    public function searchStudentGroups($data)
    {
        $number = isset($data['number']) ? $data['number'] : null;
        $name = isset($data['name']) ? $data['name'] : null;
        $specialties = isset($data['specialties']) ? $data['specialties'] : null;
        $arr_params = [];
        $sql_arr = [];

        $sql = "SELECT sg.id, sg.name, sg.number, specialties.name as specialties, specialties.description as specialty_description
        FROM student_groups sg left join specialties on specialties.id = sg.specialty_id";

        if ($number || $name || $specialties) {
            $sql .= " WHERE ";
        }

        if ($number) {
            $sql_arr[] = "sg.number = :number";
            $arr_params[':number'] = $number;
        }

        if ($name) {
            $sql_arr[] = "sg.name = :name";
            $arr_params[':name'] = $name;
        }

        if ($specialties) {
            $sql_arr[] = "sg.specialty_id in (:specialties)";
            $arr_params[':specialties'] = implode(',', $specialties);
        }
        $sql .= implode(" AND ", $sql_arr);
        return DB::select($sql, $arr_params);
    }

    /**
     * Обновляет группу студентов по id
     * @param int $id id группы студентов
     * @param string $field название поля
     * @param mixed $value содержимое поля
     * @return bool
     */
    public function updateStudentGroupById($id, $field, $value)
    {
        $studentGroup = StudentGroup::where(['id' => $id])->first();
        $studentGroup->$field = $value;
        return $studentGroup->save();
    }

    public function getName(): string
    {
        return 'student_group_repositories';
    }
}
