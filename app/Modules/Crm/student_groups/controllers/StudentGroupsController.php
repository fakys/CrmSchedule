<?php
namespace App\Modules\Crm\student_groups\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Modules\Crm\student_groups\models\SpecialtyFrom;
use App\Modules\Crm\student_groups\models\StudentGroupFrom;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
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

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
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
        return view('student_groups::groups.student_groups_info', compact('data', 'specialties', 'search_data', 'nav_students', 'title'));
    }
    public function actionAddGroup()
    {
        $form = new StudentGroupFrom('form', new FormAdditionalParam('post', route('student_groups.add_group')));

        if (request()->post()) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();

            BackendHelper::getRepositories()->createStudentGroup($return_data->getNumber(), $return_data->getName(), $return_data->getSpecialty());
            return redirect()->route('student_groups.add_group');
        }

        ViewManager::appendElement($form);
        return view('student_groups::groups.add_group');
    }
}
