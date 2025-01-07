<?php
namespace App\Modules\Crm\student_groups\repositories;

use App\Entity\Specialty;
use App\Src\modules\repository\Repository;

class SpecialtiesRepositories extends Repository
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
}
