<?php
namespace App\Modules\Crm\users_interface\operations;

use App\Modules\Crm\users_interface\src\UserData;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class UsersOperation extends AbstractOperation {

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

    /**
     * Операция добавляет пользователя
     * @param $data
     * @return UserData
     * @throws \Exception
     */
    public function addUser($data)
    {
        $user_model = new UserData($data);

        try {
            $new_user = BackendHelper::getRepositories()->createUser($user_model->getDataForUsersTable());

            $user_info = BackendHelper::getRepositories()->createUserInfo(
                $user_model->getDataForUsersInfoTable(), $new_user->id
            );
            $user_document = BackendHelper::getRepositories()->createUserDocument(
                $user_model->getDataForUsersDocumentsTable(), $new_user->id
            );

            //добавляем пользователя в группы
            BackendHelper::getOperations()->addUserInGroups($new_user->id, $user_model->getGroups());

            if ($new_user && $user_document && $user_info) {
                return $user_model;
            }

            if($new_user){
                $new_user->delete();
            }
            throw new \Exception('При создание пользователя, произошла ошибка');
        } catch (\Exception $e) {
            if($new_user){
                $new_user->delete();
            }
            throw new \Exception('При создание пользователя, произошла ошибка: ' . $e->getMessage()." ".$e->getTraceAsString());
        }
    }

    public function getName(): string
    {
        return 'users_operation';
    }
}
