<?php
namespace App\Modules\Crm\schedule\controllers;

use App\Modules\Crm\schedule\models\SemestersModel;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use function Termwind\render;

class SemestersController extends Controller {


    /** Акшен семестров */
    public function actionSemesters()
    {
        $semesters = BackendHelper::getOperations()->getSemesters();
        $title = 'Семестры';
        return view('semesters.index', compact('semesters','title'));
    }

    /** Акшен создания семестров */
    public function actionSemestersAdd()
    {
        $title = 'Добавить семестр';
        return view('semesters.form', compact('title'));
    }

    /** Акшен сохранения семестров в бд */
    public function semestersAdd()
    {
        $model = new SemestersModel();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate()){
            BackendHelper::getRepositories()->createSemester($model);
            return redirect(route('schedule.semesters'));
        }
        abort(500);
    }

    /** Акшен удаления семестров из бд */
    public function deleteSemester()
    {
        $id = request()->post('semesters_id');
        if ($id) {
            return BackendHelper::getRepositories()->deleteSemesterById($id);
        }
        return false;
    }

    /** Акшен для изменения семестра */
    public function actionSemestersEdit()
    {
        $title = 'Изменить семестр';
        $semester_id = request()->get('semester_id');
        $semester = BackendHelper::getRepositories()->getSemesterById($semester_id);
        return view('semesters.form', compact('title', 'semester'));
    }

    public function semestersEdit()
    {
        $semester_id = request()->get('semester_id');
        $semester = BackendHelper::getRepositories()->getSemesterById($semester_id);
        $model = new SemestersModel();
        $model->load(request()->post());
        $model->id = $semester_id;
        $validate = Validator::make($model->getData(), $model->rules());
        if ($semester && $validate->validate() && $model->dateValidate()) {
            BackendHelper::getRepositories()->updateSemester($semester->id, $model->getData());
        }
        return redirect(route('schedule.semesters'));
    }
}
