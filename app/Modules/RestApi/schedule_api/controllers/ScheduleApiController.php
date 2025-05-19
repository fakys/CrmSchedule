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
}
