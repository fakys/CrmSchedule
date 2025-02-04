<?php
namespace App\Modules\Crm\student_groups\controllers;

use App\Modules\Crm\student_groups\models\AddSpecialty;
use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class SpecialtiesController extends Controller{

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
