<?php
namespace App\Modules\Crm\auth\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;


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

    }
}
