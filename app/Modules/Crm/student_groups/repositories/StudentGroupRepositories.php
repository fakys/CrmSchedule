<?php
namespace App\Modules\Crm\student_groups\repositories;

use App\Entity\Specialty;
use App\Entity\StudentGroup;
use App\Src\modules\repository\Repository;

class StudentGroupRepositories extends Repository
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
}
