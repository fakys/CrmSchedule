<?php
namespace App\Modules\Crm\student_groups\controllers;

use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class StudentGroupsController extends Controller{

    public function actionAddGroup()
    {
        $specialties = BackendHelper::getRepositories()->getAllSpecialties();
        return view('groups.add_group', compact('specialties'));
    }

    public function addGroup()
    {
        $model = new AddStudentGroup();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate()){
            BackendHelper::getRepositories()->createStudentGroup($model->number, $model->name, $model->specialty);
        }
        return redirect()->route('student_groups.add_group');
    }
}
