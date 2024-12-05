<?php
namespace App\Modules\Crm\users_interface\repositories;



use App\Entity\User;
use App\Entity\UserDocumet;
use App\Entity\UserInfo;
use App\Src\BackendHelper;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class UsersRepositories extends Repository {
    public function getFullUsersInfo()
    {
        $users = DB::select(
            "SELECT users.id, username as name,
                u_info.last_name|| ' ' || u_info.first_name || ' ' || u_info.patronymic as fio, u_info.email,
                u_info.number_phone, u_doc.inn, u_doc.snils, to_char(u_info.birthday, 'DD.MM.YYYY') as birthday FROM users
                join users_info as u_info on u_info.user_id = users.id
                join users_documents as u_doc on u_doc.user_id = users.id");

        return $users;
    }

    public function getUserList($data)
    {
        $users = User::where($data[0])->get();
        return $users;
    }

    public function getUserById($id)
    {
        $user = User::where(['id'=>$id[0]])->fist();
        return $user;
    }

    public function updateUsersById($id, $data)
    {
        $user = BackendHelper::getRepositories()->getUserById($id[0]);
        foreach($data as $field => $value){

        }
    }

    public function updateUsersInfoById($data)
    {
        $id = $data[0]['id'];
        $info = UserInfo::where(['user_id'=>$id])->first();
        return $info->update($data[0]['value']);
    }
    public function updateUsersDocumentById($data)
    {
        $id = $data[0]['id'];
        $info = UserDocumet::where(['user_id'=>$id])->first();
        return $info->update($data[0]['value']);
    }

    public function saveAccessUser($data)
    {
        if(isset($data[0])){
            $id = $data[0]['id'];
            $user = BackendHelper::getRepositories()->getUserById($id);
            if($user){
                $model = $data[0]['model'];
                $user->username = $model->username;
                $user->password = $model->password;
                return $user->save();
            }
        }
        return false;
    }
}
