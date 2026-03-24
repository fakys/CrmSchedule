<?php
namespace App\Modules\Crm\auth\controllers;

use App\Assets\BaseLayoutBundle;
use App\Modules\Crm\auth\models\formsReturnData\LoginFormReturnData;
use App\Modules\Crm\auth\models\LoginFormModel;
use App\Modules\Crm\auth\models\LoginModel;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;
use App\Src\modules\kernel\KernelModules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;


class AuthController extends AbstractController
{

    static function loadController(KernelModules $kernel)
    {

    }

    static function assets(): array
    {
        return [
            BaseLayoutBundle::class
        ];
    }

    public function actionLogin()
    {
        $form = new LoginFormModel('login_form', new FormAdditionalParam('POST', route('auth.login')));
        ViewManager::appendElement($form);

        return view('auth::login');
    }

    public function login()
    {
        if(request()->isMethod('POST')){
            $form = new LoginFormModel('login_form', new FormAdditionalParam('POST', route('auth.login')));
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            /** @var LoginFormReturnData $return_data */
            $return_data = $form->getReturnData();
            if(BackendHelper::getOperations()->loginUser($return_data->getLogin(), $return_data->getPassword(), $return_data->getRemember())){
                return redirect(route('interface.index'));
            }
        }
        return redirect(route('auth.login'));
    }

    public function actionLogout()
    {
        Auth::logout();
        return redirect(route('auth.login'));
    }
}
