<?php
namespace App\Modules\Crm\schedule\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\schedule\models\SemesterFormModel;
use App\Modules\Crm\schedule\models\SemestersModel;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
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

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
    }

    /** Акшен семестров */
    public function actionSemesters()
    {
        $semesters = BackendHelper::getOperations()->getSemesters();
        $title = 'Семестры';
        return view('schedule::semesters.index', compact('semesters','title'));
    }

    /** Акшен создания семестров */
    public function actionSemestersAdd()
    {
        $title = 'Добавить семестр';
        $form = new SemesterFormModel('form', new FormAdditionalParam('post', route('schedule.add_semesters')));

        if (request()->isMethod('POST')) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();

            BackendHelper::getRepositories()->createSemester(
                $return_data->getName(),
                date('Y-m-d', strtotime($return_data->getDateStart())),
                date('Y-m-d', strtotime($return_data->getDateEnd())),
                $return_data->getYearStart(),
                $return_data->getYearEnd()
            );

            return redirect()
                ->route('schedule.semesters')
                ->with(['successMessage' => 'Семестр успешно создан']);
        }

        ViewManager::appendElement($form);
        return view('schedule::semesters.form', compact('title'));
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
        $form = new SemesterFormModel('form', new FormAdditionalParam('post', route('schedule.semester_edit')), $semester->id);

        $data = $semester->toArray();
        $data['date_start'] = date('Y-m-d', strtotime($data['date_start']));
        $data['date_end'] = date('Y-m-d', strtotime($data['date_end']));
        $form->load($data);

        if (request()->isMethod('POST')) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();
            BackendHelper::getRepositories()->updateSemester($semester_id, $return_data->toArray());

            return redirect()
                ->route('schedule.semesters')
                ->with(['successMessage' => 'Семестр успешно обновлен']);
        }
        ViewManager::appendElement($form);
        return view('schedule::semesters.form', compact('title'));
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

        }
        return redirect(route('schedule.semesters'));
    }
}
