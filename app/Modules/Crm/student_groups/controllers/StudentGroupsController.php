<?php
namespace App\Modules\Crm\student_groups\controllers;

use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class StudentGroupsController extends Controller{

    public function actionStudentGroupsInfo()
    {
        if(request()->isMethod('post')){
            $data = BackendHelper::getRepositories()->searchStudentGroups(request()->post());

        }else{
            $data = BackendHelper::getRepositories()->getStudentGroupsInfo();
        }
        request()->session()->put('student-groups-info', request()->post());
        $search_data = request()->session()->get('student-groups-info');

        $specialties = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllSpecialties(), 'name', 'id');
        $nav_students = true;
        $title = 'Все группы';
        return view('groups.student_groups_info', compact('data', 'specialties', 'search_data', 'nav_students', 'title'));
    }
    public function actionAddGroup()
    {
        $specialties = BackendHelper::getRepositories()->getAllSpecialties();
        return view('groups.add_group', ['specialties'=>$specialties, 'nav_operation'=>true]);
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
