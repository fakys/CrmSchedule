<?php
namespace App\Modules\Crm\users_interface\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;
class UsersOperation extends Operation {
    public function UpdateFullUser($data)
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
        $value = $data[0]['value'];
        foreach ($value as $field => $val) {
            if(in_array($field, $fields['info'])){
                return BackendHelper::getRepositories()->updateUsersInfoById($data[0]);
            }elseif (in_array($field, $fields['document'])){
                return BackendHelper::getRepositories()->updateUsersDocumentById($data[0]);
            }
        }
        return false;
    }
}
