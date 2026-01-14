<?php
namespace App\Modules\Crm\schedule\controllers;

use App\Modules\Crm\schedule\models\SemestersModel;
use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;
use App\Src\modules\controllers\loaders\RmGroupLinkLoader;
use App\Src\modules\controllers\loaders\RmLink;
use App\Src\modules\controllers\RmGroupLoader;
use App\Src\modules\kernel\KernelModules;
use Illuminate\Support\Facades\Validator;

class SemestersController extends AbstractController {

    static function loadController(KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->setText('РМ Преподавателя')
            ->setIcon('fa fa-graduation-cap')
            ->setAccess('rm_teachers_access');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('schedule_list')
            ->setName('schedule_list')
            ->setIcon('fa fa-list-alt')
            ->setText('Расписание')
            ->setAccess('schedule_list_access');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')->RmGroupList('schedule_list')
            ->RmLink('semesters')
            ->setText('Семестры')
            ->setLink(route('schedule.semesters'));
    }

    /** Акшен семестров */
    public function actionSemesters()
    {
        $semesters = BackendHelper::getOperations()->getSemesters();
        $title = 'Семестры';
        $nav_schedule = true;
        return view('schedule::semesters.index', compact('semesters','title', 'nav_schedule'));
    }

    /** Акшен создания семестров */
    public function actionSemestersAdd()
    {
        $title = 'Добавить семестр';
        $nav_schedule = true;
        return view('schedule::semesters.form', compact('title', 'nav_schedule'));
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
        $nav_schedule = true;
        return view('schedule::semesters.form', compact('title', 'semester', 'nav_schedule'));
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
