<?php

namespace App\Modules\Crm\users_interface\controllers;

use App\Modules\Crm\users_interface\model\UserAddGroups;
use App\Modules\Crm\users_interface\model\EditUserTabs;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class TabsController extends Controller
{

    public function getUsersTableTabs()
    {
        return view('tabs.users_table_tabs');
    }

    public function getUserInfoTabs()
    {
        $data = [];
        if (isset(request()['id'])) {
            $user = BackendHelper::getRepositories()->getUserById(request()['id']);
            $data = [
                'user' => $user,
                'info' => $user->getInfo(),
                'documents' => $user->getDocument(),

            ];
        }
        return view('tabs.user_info_tabs', ['data' => $data]);
    }

    public function getEditUserInfoTabs()
    {
        $data = [];
        if (isset(request()['id'])) {
            $user = BackendHelper::getRepositories()->getUserById(request()['id']);
            $data = [
                'user' => $user,
                'info' => $user->getInfo(),
                'documents' => $user->getDocument(),

            ];
        }
        return view('tabs.edit_user_info_tabs', ['data' => $data]);
    }

    /**
     * Action обновления информации о пользователе
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setEditUserInfoTabs()
    {
        if (request()->post()) {
            $model = new EditUserTabs();
            $model->load([request()->post()['field'] => isset(request()->post()['value']) ? request()->post()['value'] : '']);
            $validate = Validator::make($model->getData(), $model->rules());
            if ($validate->validate() && $model->customValidate()) {
                if (isset(request()->post()['id']) && $model->getData()) {
                    return BackendHelper::getOperations()->UpdateFullUser(request()->post()['id'], $model->getData());
                }
                return true;
            } elseif ($model->getErrors()) {
                abort(422, $model->getErrors()[request()->post()['field']]);
            }
        }
        abort(422, 'Ошибка обновления');
    }

    /**
     * Таб Изменения доступа
     */
    public function getAccessTabs()
    {
        $id = request()->post('id');
        $user = BackendHelper::getRepositories()->getUserById($id);
        return view('tabs.access_tabs', compact('user'));
    }

    /**
     * Action для сохранения доступов
     */
    public function setAccessTabs()
    {
        $data = request()->post('data');
        $id = request()->post('data')['id'];
        $model = new UserAddGroups();
        $model->load($data);
        $validate = Validator::make($model->getData(), $model->rules());
        if ($validate->validate()) {
            if (BackendHelper::getRepositories()->saveAccessUser($id, $model)) {
                return true;
            }
        }
        abort(422, 'Ошибка обновления');
    }

    /**
     * Таб групп пользователя
     */
    public function getUserGroupsTabs()
    {
        $users_groups = BackendHelper::getRepositories()->getAllUsersGroup();
        $user_in_group = BackendHelper::getRepositories()->getGroupsUserByUserId(request()->post('id'));
        return view('tabs.user_groups', compact('users_groups', 'user_in_group'));
    }

    /**
     * Возвращает таб для студенческих групп
     */
    public function getTabForStudentGroups()
    {
        return view('tabs.student_groups_tab');
    }

    public function getFullInfoStudentGroups()
    {
        if (request()->post()) {
            $id = request()->post()['id'];
            $user_group = BackendHelper::getRepositories()->getStudentGroupById($id);
            $specialty = $user_group->getSpecialty()->get();
            return view('tabs.get_full_info_student_groups', compact('user_group', 'specialty'));
        }
        abort(500);
    }

    public function editFullInfoStudentGroups()
    {
        if (request()->post()) {
            $id = request()->post()['id'];
            $user_group = BackendHelper::getRepositories()->getStudentGroupById($id);
            $specialty = $user_group->getSpecialty()->first();
            return view('tabs.edit_full_info_student_groups', compact('user_group', 'specialty'));
        }
        abort(500);
    }

    public function setEditStudentGroups()
    {
        if (request()->post()) {
            $table = request()->post('table');
            if ($table) {
                switch ($table) {
                    case 'specialty':
                        return BackendHelper::getRepositories()->updateSpecialtyByStudentGroupId(
                            request()->post('id'),
                            request()->post('field_name'),
                            request()->post('value')
                        );
                    case 'groups':
                        return BackendHelper::getRepositories()->updateStudentGroupById(
                            request()->post('id'),
                            request()->post('field_name'),
                            request()->post('value')
                        );
                }
            }
        }
        abort(500);
    }

    /**
     * Возвращает таб для предметов
     */
    public function getTabForSubjects()
    {
        return view('tabs.subjects_tabs');
    }

    /**
     * Таб информация о предмете
     */
    public function getSubjectInfoTab()
    {
        if (request()->post()) {
            $id = request()->post()['id'];
            $subject = BackendHelper::getRepositories()->getSubjectById($id);
            return view('tabs.get_subject_info', compact('subject'));
        }
        abort(500);
    }

    /**
     * Таб редактирования информации о предмете
     */
    public function actionEditSubjectInfoTab()
    {
        if (request()->post()) {
            $id = request()->post()['id'];
            $subject = BackendHelper::getRepositories()->getSubjectById($id);
            return view('tabs.edit_subject_info', compact('subject'));
        }
        abort(500);
    }

    /**
     * Редактирования информации о предмете
     */
    public function editSubjectInfoTab()
    {
        if (request()->post()) {
            $id = request()->post('id');
            $field = request()->post('field');
            $value = request()->post('value');
            return BackendHelper::getRepositories()->updateSubjectField($id, $field, $value);
        }
        abort(500);
    }
}
