<?php
namespace App\Modules\Crm\auth\controllers;

use App\Modules\Crm\auth\models\LoginModel;
use App\Src\BackendHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class AuthController extends Controller {
    public function actionLogin()
    {
        return view('login');
    }

    public function login()
    {
        if(request()->isMethod('POST')){
            $model = new LoginModel();
            $model->load(request()->post());
            $validate = Validator::make($model->getData(), $model->rules());
            if($validate->validate()){
                if($model->login()){
                    return redirect(route('interface.index'));
                }
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
