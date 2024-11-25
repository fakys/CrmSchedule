<?php
namespace App\Modules\Crm\users_interface\repositories;



use App\Entity\User;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class UsersRepositories extends Repository {
    public function getFullUsersInfo()
    {
        $users = DB::select(
            "SELECT users.id, username as name,
                u_info.last_name|| ' ' || u_info.first_name || ' ' || u_info.patronymic as fio, u_info.email,
                u_info.number_phone, u_doc.inn, u_doc.snils, u_info.birthday  FROM users
                join users_info as u_info on u_info.user_id = users.id
                join users_documents as u_doc on u_doc.user_id = users.id");
        return $users;
    }

    public function getUserById($id)
    {
        $user = User::where(['id'=>$id[0]])->get();
        if($user){
            return $user[0];
        }
        return [];
    }
}
