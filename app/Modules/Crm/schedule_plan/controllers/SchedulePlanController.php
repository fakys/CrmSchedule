<?php
namespace App\Modules\Crm\schedule_plan\controllers;

use Illuminate\Routing\Controller;


class SchedulePlanController extends Controller{


    public function actionSchedulePlan()
    {
        return view('schedule_plan.index', ['title'=>'Плана расписания']);
    }
}
