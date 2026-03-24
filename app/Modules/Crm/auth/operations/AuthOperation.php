<?php
namespace App\Modules\Crm\auth\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Операция авторизации
 */
class AuthOperation extends AbstractOperation {

    public function getName(): string
    {
        return 'auth_operation';
    }

    /**
     * Логин пользователя
     * @param $username
     * @param $password
     * @param $remember
     * @return bool
     */
    public function loginUser($username, $password, $remember = false): bool
    {
        $users = BackendHelper::getRepositories()->getUserList(['username'=>$username]);
        if($users->count()){
            $user = $users->first();
            if(Hash::check($password, $user->password)){
                Auth::login($user, $remember);
                return true;
            }
        }
        return false;
    }
}
