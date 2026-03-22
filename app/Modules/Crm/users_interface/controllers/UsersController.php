<?php
namespace App\Modules\Crm\users_interface\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\schedule_plan\src\ExcelPlanSchedule;
use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Modules\Crm\users_interface\model\AddUser;
use App\Modules\Crm\users_interface\model\MasseAddTeacherModel;
use App\Modules\Crm\users_interface\src\ExcelMasseAddTeachers;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UsersController extends AbstractController {
    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmGroupList('users_list')
            ->setText('Пользователи')
            ->setIcon('fa fa-user');

        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('users_list')
            ->RmLink('users')->setText('Пользователи')
            ->setLink(route('users_interface.users_info'));

        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->RmLink('add_user')->setText('Добавить пользователя')
            ->setLink(route('users_interface.add_user'));

        $kernel->getControllerLoader()->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->RmLink('add_user')->setText('Массовое добавление учителей')
            ->setLink(route('users_interface.masse_add_teacher'));
    }

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
    }

    public function actionUsersInfo()
    {
        $search_data = request()->session()->has('search-user-info')
            ? request()->session()->get('search-user-info') : [];

        if (request()->method() == 'POST') {
            $data = BackendHelper::getRepositories()->getFullUsersInfoSearch(request()->post());
            if($search_data){
                request()->session()->forget('search-user-info');
            }
            request()->session()->put('search-user-info', request()->post());
            $search_data = request()->session()->get('search-user-info');
        } else {
            if (request()->session()->has('search-user-info')) {
                $data = BackendHelper::getRepositories()->getFullUsersInfoSearch($search_data);
            } else {
                $data = BackendHelper::getRepositories()->getFullUsersInfo();
            }
        }

        $users_group = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
        return view('users_interface::users.users_info', ['data' => $data, 'title'=>'Пользователи',
            'users_group'=>$users_group,
            'search_data'=>$search_data,
            'nav_users'=>true
        ]);
    }

    public function checkUserAccess()
    {
        $url = request()->post('links');
        return BackendHelper::getOperations()->hasAccessesByUrl($url);
    }

    public function actionAddUser()
    {
        $users_group = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id');
        return view('users_interface::users.add_user', ['users_group'=>$users_group, 'nav_operation'=>true]);
    }

    public function addUser()
    {
        if (request()->method() == 'POST') {
            $model = new AddUser();
            $model->load(request()->post());
            $validate = Validator::make($model->getData(), $model->rules());
            if($validate->validate() && $model->parseFio()){
                BackendHelper::getOperations()->addUser($model->getData());
            }
        }
        return redirect()->route('users_interface.users_info');
    }

    public function actionDownloadTemplateMasseAddTeacher()
    {
        return Excel::download(new ExcelMasseAddTeachers(), 'add_teachers.xlsx');
    }

    /**
     * Массовое добавление преподавателей
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws \Illuminate\Validation\ValidationException
     */
    public function actionMasseAddTeachers()
    {
        if (request()->method() == 'POST') {
            $model = new MasseAddTeacherModel();
            $validate = Validator::make($model->getData(), $model->rules());
            $validate->validate();
            $file = request()->file('file');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $schedule_data_file = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            /** @var  $data */
            $data = ExcelMasseAddTeachers::parseData($schedule_data_file, $validate);
            /** todo отправка временного пароля */
            foreach ($data as $item) {
                BackendHelper::getOperations()->addUser($item);
            }
        }
        return view('users_interface::users.masse_add_teachers', []);
    }
}
