<?php
namespace App\Modules\Crm\student_groups\controllers;

use App\Modules\Crm\student_groups\models\AddSpecialty;
use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class SpecialtiesController extends AbstractController
{
    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->RmLink('add_specialties_operation')
            ->setText('Добавить специальность')
            ->setLink(route('student_groups.add_specialty'));
    }
    public function actionAddSpecialty()
    {
        return view('specialties.add_specialty', ['nav_operation'=>true]);
    }

    public function addSpecialty()
    {
        $model = new AddSpecialty();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate()){
            BackendHelper::getRepositories()->createSpecialty($model->number, $model->name, $model->description);
        }
        return redirect()->route('student_groups.add_specialty');
    }
}
