<?php

namespace App\Modules\Crm\student_groups\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Modules\Crm\student_groups\models\SpecialtyFrom;
use App\Modules\Crm\student_groups\models\StudentGroupFrom;
use App\Modules\Crm\student_groups\models\StudentGroupTable;
use App\Modules\Crm\student_groups\requests\MasseAddStudentGroupRequest;
use App\Modules\Crm\student_groups\src\ExcelMasseAddStudentsGroup;
use App\Modules\Crm\student_groups\src\MassAddStudentsGroupEntity;
use App\Modules\Crm\users_interface\src\ExcelMasseAddTeachers;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectSearch;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;


class StudentGroupsController extends AbstractController
{

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

        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->RmLink('masse_add_students_group')->setText('Массовое добавление групп студентов')
            ->setLink(route('student_groups.masse_add_students_group'));
    }

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
    }

    public function actionStudentGroupsInfo()
    {
        if (request()->isMethod('post')) {
            $data = BackendHelper::getRepositories()->searchStudentGroups(request()->post());
            request()->session()->put('student-groups-info', request()->post());
        } else {
            $data = BackendHelper::getRepositories()->getStudentGroupsInfo();
        }
        $table = new StudentGroupTable('table', $data, route('users_interface.get_tab_for_student_groups'));

        $search_data = request()->session()->get('student-groups-info');
        $select = new SelectSearch(
            'specialties',
            ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllSpecialties(), 'name', 'id'),
            new LabelAdditionalParams(),
            new SelectElementAdditionalParams(true),
            $search_data['specialties'] ?? null
        );
        ViewManager::appendElement($select);
        ViewManager::appendElement($table);

        $title = 'Все группы студентов';
        return view('student_groups::groups.student_groups_info', compact('data', 'search_data', 'title'));
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

    public function actionMasseAddStudentGroup()
    {
        $select = new SelectSearch(
            'speciality',
            ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllSpecialties(), 'name', 'id'),
            new LabelAdditionalParams('Специальность'),
            new SelectElementAdditionalParams()
        );
        ViewManager::appendElement($select);
        return view('student_groups::groups.masse_add_students_group');
    }

    public function masseAddStudentGroup(MasseAddStudentGroupRequest $request)
    {
        $request->validated();
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $data_file = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        unset($data_file[array_key_first($data_file)]);

        $data = [];
        foreach ($data_file as $item) {
            $data[] = new MassAddStudentsGroupEntity($item['A'], $item['B']);
        }
        try {
            BackendHelper::getOperations()->massAddStudentsGroup($data, $request->post('speciality'));
        } catch (\Exception $e) {
            Log::error('[masseAddStudentGroup] '.$e->getMessage().$e->getTraceAsString());
            return redirect()
                ->route('student_groups.masse_add_students_group')
                ->with(['errorMessage' => 'Ошибка создания группы']);
        }

        return redirect()
            ->route('student_groups.masse_add_students_group')
            ->with(['successMessage' => 'Группы студентов успешно созданы!']);
    }

    public function actionDownloadTemplateMasseAddTeacher()
    {
        return Excel::download(new ExcelMasseAddStudentsGroup(), 'add_students.xlsx');
    }
}
