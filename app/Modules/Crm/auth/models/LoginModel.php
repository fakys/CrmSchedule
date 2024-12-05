<?php
namespace App\Modules\Crm\auth\models;

use App\Src\BackendHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginModel extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'username',
            'password',
            'remember'
        ];
    }

    public function rules(): array
    {
        return [
            'username'=>['required','string'],
            'password'=>['required','string'],
            'remember'=>[],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

    public function login()
    {
        $users = BackendHelper::getRepositories()->getUserList(['username'=>$this->getData()['username']]);
        $remember = isset($this->getData()['remember'])?$this->getData()['remember']:0;
        if($users->count()){
            $user = $users->first();
            if(Hash::check($this->getData()['password'], $user->password)){
                Auth::login($user, );
                return true;
            }
        }
        return false;
    }
}
