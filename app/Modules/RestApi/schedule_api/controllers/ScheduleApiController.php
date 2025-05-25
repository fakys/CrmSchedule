<?php
namespace App\Modules\RestApi\schedule_api\controllers;

use App\Modules\RestApi\schedule_api\models\ReturnArray;
use App\Modules\RestApi\schedule_api\models\ReturnBool;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;

class ScheduleApiController extends Controller
{

    public function getAllSpecialties()
    {
        return ReturnArray::return(BackendHelper::getRepositories()->getAllSpecialties()->toArray());
    }

    public function getAllStudentsGroups()
    {
        return ReturnArray::return(BackendHelper::getRepositories()->getFullStudentGroups()->toArray());
    }

    public function getAllUsers()
    {
        return ReturnArray::return(BackendHelper::getRepositories()->getFullUsersInfo());
    }

    public function getPairNumbers()
    {
        return ReturnArray::return(BackendHelper::getRepositories()->getNumberPair()->toArray());
    }

    public function getGroupByName()
    {
        return ReturnArray::return(BackendHelper::getRepositories()->getStudentGroupByName(request()->post('group_name')));
    }

    public function getActualScheduleByGroup()
    {
        return ReturnArray::return(BackendHelper::getOperations()->getActualScheduleByGroup(request()->post('group_name')));
    }

    public function getActualScheduleByTeacher()
    {
        return ReturnArray::return(BackendHelper::getOperations()->getActualScheduleByTeacherFio(request()->post('fio')));
    }

    public function hasTeacher()
    {
        return ReturnBool::return(BackendHelper::getRepositories()->getFullUsersInfoSearch(['fio'=>request()->post('fio')]));
    }

    public function hasStudentsGroups()
    {
        return ReturnBool::return(BackendHelper::getRepositories()->getStudentGroupByName(request()->post('group_name')));
    }
}
