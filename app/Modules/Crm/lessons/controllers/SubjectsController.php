<?php

namespace App\Modules\Crm\lessons\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\lessons\models\AddSubjectFormModel;
use App\Modules\Crm\lessons\models\AllSubjectTable;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;

class SubjectsController extends AbstractController
{
    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->setOpen(true)
            ->RmGroupList('subjects_list')
            ->setIcon('fa fa-book')
            ->setText('Предметы')
            ->setAccess('subjects_list_access');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')->RmGroupList('subjects_list')
            ->RmLink('all_subjects')
            ->setText('Все предметы')
            ->setLink(route('lessons.subjects_info'));

        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->setText('РМ Руководителя')
            ->setOpen(true)
            ->setIcon('fa fa-cogs nav-icon')
            ->RmGroupList('operations')
            ->setIcon('fa fa-cogs')
            ->setText('Операции')
            ->RmLink('add_subject_operation')
            ->setText('Добавить предмет')
            ->setLink(route('lessons.action_add_subject'));
    }

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
    }

    public function actionAddSubject()
    {
        $form = new AddSubjectFormModel('add_subject', new FormAdditionalParam('post', route('lessons.action_add_subject')));

        if (request()->post()) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $data = $form->getReturnData();
            BackendHelper::getRepositories()->createSubject($data->getName(), $data->getFullName(), $data->getDescription());
        }

        ViewManager::appendElement($form);

        return view('lessons::subjects.add_subject');
    }

    public function actionSubjectsInfo()
    {
        $search_data = request()->session()->has('search-subject-info')
            ? request()->session()->get('search-subject-info') : [];

        if (request()->method() == 'POST') {
            $subjects = BackendHelper::getRepositories()->getSearchSubjectInfo(request()->post());
            if ($search_data) {
                request()->session()->forget('search-subject-info');
            }
            request()->session()->put('search-subject-info', request()->post());
            $search_data = request()->session()->get('search-subject-info');
        } else {
            if (request()->session()->has('search-subject-info')) {
                $subjects = BackendHelper::getRepositories()->getSearchSubjectInfo($search_data);
            } else {
                $subjects = BackendHelper::getRepositories()->getSubjectInfo();
            }
        }

        $table = new AllSubjectTable('table', $subjects, route('users_interface.get_tab_for_subjects'));
        ViewManager::appendElement($table);

        return view('lessons::subjects.subjects_info', [
            'subjects' => $subjects,
            'title' => 'Все предметы',
            'search_data' => $search_data
        ]);
    }
}
