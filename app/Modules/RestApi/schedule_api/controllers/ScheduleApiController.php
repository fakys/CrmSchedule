<?php
namespace App\Modules\RestApi\schedule_api\controllers;

use App\Modules\RestApi\schedule_api\models\ReturnArray;
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
}
