<?php
namespace App\Modules\Crm\student_groups\repositories;

use App\Entity\Specialty;
use App\Entity\StudentGroup;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;

class SpecialtiesRepositories extends AbstractRepositories
{
    /**
     * @param array $data
     * @return Specialty|null
     */
    public function createSpecialty($number, $name, $description = '')
    {
        $specialty = new Specialty();
        $specialty->name = $name;
        $specialty->description = $description;
        $specialty->number = $number;

        if($specialty->save()){
            return $specialty;
        }
        return null;
    }

    /**
     * Возвращает все специальности
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSpecialties()
    {
        return Specialty::all();
    }

    /**
     * Возвращает специальность по id
     * @return Specialty
     */
    public function getSpecialtyById($id)
    {
        return Specialty::where(['id'=>$id])->first();
    }


    /**
     * Обновляет специальность по id группы
     * @param $id
     * @param $field
     * @param $value
     * @return mixed
     */
    public function updateSpecialtyByStudentGroupId($id, $field, $value)
    {
        $student_group = StudentGroup::where(['id'=>$id])->first();
        $specialty = $student_group->getSpecialty()->first();
        if($specialty){
            $specialty->$field = $value;
            return $specialty->save();
        }
        return false;
    }

    public function getName(): string
    {
        return 'specialties_repositories';
    }
}
