<?php
namespace App\Modules\Crm\users_interface\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;
class UsersOperation extends Operation {
    public function UpdateFullUser($id, $value)
    {
        $fields = [
            'info'=>[
                'last_name',
                'first_name',
                'patronymic',
                'email',
                'number_phone',
                'birthday'
            ],
            'document'=>[
                'inn',
                'passport_series',
                'passport_number',
                'snils',
                'address'
            ],
        ];
        foreach ($value as $field => $val) {
            if(in_array($field, $fields['info'])){
                return BackendHelper::getRepositories()->updateUsersInfoById($id, [$field=>$val]);
            }elseif (in_array($field, $fields['document'])){
                return BackendHelper::getRepositories()->updateUsersDocumentById($id, [$field=>$val]);
            }
        }
        return false;
    }
}
