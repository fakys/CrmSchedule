<?php
namespace App\Modules\Crm\student_groups\controllers;

use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class StudentGroupsController extends AbstractController {

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->setText('РМ Преподавателя')
            ->setIcon('fa fa-graduation-cap')
            ->setAccess('rm_teachers_access');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('students')
            ->setText('Студенты')
            ->setIcon('fa fa-users');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('students')
            ->RmLink('students_groups')
            ->setText('Группы')
            ->setLink(route('student_groups.student_groups_info'));

        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->setIcon('fa fa-cogs')
            ->setText('Операции')
            ->RmLink('add_students_group_operation')
            ->setText('Добавить группу')
            ->setLink(route('student_groups.add_group'));
    }

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
