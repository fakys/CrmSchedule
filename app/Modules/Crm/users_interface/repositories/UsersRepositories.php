<?php
namespace App\Modules\Crm\users_interface\repositories;



use App\Entity\User;
use App\Entity\UserDocumet;
use App\Entity\UserInfo;
use App\Src\BackendHelper;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class UsersRepositories extends AbstractRepositories
{
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

    /**
     * Выдает информацию по пользователю с поиском
     * @param $data
     * @return array
     */
    public function getFullUsersInfoSearch($data)
    {
        $login = isset($data['login']) ? $data['login'] : null;
        $fio = isset($data['fio']) ? $data['fio'] : null;
        $number = isset($data['number']) ? $data['number'] : null;
        $email = isset($data['email']) ? $data['email'] : null;
        $inn = isset($data['inn']) ? $data['inn'] : null;
        $groups = isset($data['groups']) ? implode(',', $data['groups']) : null;
        $arr_params = [];
        $sql_arr = [];

        $sql = "SELECT users.id, username as name,
                u_info.last_name|| ' ' || u_info.first_name || ' ' || u_info.patronymic as fio, u_info.email,
                u_info.number_phone, u_doc.inn, u_doc.snils, to_char(u_info.birthday, 'DD.MM.YYYY') as birthday FROM users
                join users_info as u_info on u_info.user_id = users.id
                join users_documents as u_doc on u_doc.user_id = users.id";

        if ($login) {
            $sql_arr[] = "users.username = :login";
            $arr_params[':login'] = $login;
        }
        if ($number) {
            $sql_arr[] = "u_info.number_phone = :number ";
            $arr_params[':number'] = $number;
        }

        if ($fio) {
            $sql_arr[] = "u_info.last_name|| ' ' || u_info.first_name || ' ' || u_info.patronymic = :fio ";
            $arr_params[':fio'] = $fio;
        }

        if ($email) {
            $sql_arr[] = "u_info.email = :email ";
            $arr_params[':email'] = $email;
        }

        if ($inn) {
            $sql_arr[] = "u_doc.inn = :inn ";
            $arr_params[':inn'] = $inn;
        }

        if ($groups) {
            $sql_arr[] = "(SELECT count(id) from groups_users as g_use
            where g_use.users_id = users.id AND g_use.user_group_id in (:groups))>=1";
            $arr_params[':groups'] = $groups;
        }

        if ($login || $fio || $number || $email || $inn || $groups) {
            $sql .= " WHERE ".implode(" AND ", $sql_arr);
        }

        return DB::select($sql, $arr_params);
    }

    /**
     * Возвращает всех активных пользователей
     * @return \Illuminate\Database\Eloquent\Collect
     */
    public function getAllActiveUsers()
    {
        $users = DB::select(
            "SELECT * FROM users WHERE afk=false and blocked=false and deleted=false");

        return $users;
    }

    public function getUserList($data)
    {
        $users = User::where($data)->get();
        return $users;
    }

    /**
     * @return User[]
     */
    public function getAllTeachers()
    {
        return User::leftJoin('groups_users', 'groups_users.users_id', '=', 'users.id')
            ->whereIn('groups_users.user_group_id', BackendHelper::getSystemSettings('schedule_settings')->users_groups)
            ->select('users.id', 'users.username', 'users.password', 'users.deleted', 'users.blocked', 'users.afk')
            ->get();
    }

    public function getUserById($id)
    {
        $user = User::where(['id'=>$id])->first();
        return $user;
    }

    public function updateUsersById($id, $data)
    {
        $user = BackendHelper::getRepositories()->getUserById($id);
        foreach($data as $field => $value){
            $user->$field = $value;
        }
        return $user->save();
    }

    public function updateUsersInfoById($id, $value)
    {
        $info = UserInfo::where(['user_id'=>$id])->first();
        return $info->update($value);
    }
    public function updateUsersDocumentById($id, $value)
    {
        $info = UserDocumet::where(['user_id'=>$id])->first();
        return $info->update($value);
    }

    public function saveAccessUser($id, $model)
    {
        $user = BackendHelper::getRepositories()->getUserById($id);
        if ($user) {
            $user->username = $model->username;
            $user->password = $model->password;
            return $user->save();
        }
        return false;
    }

    /**
     * Репозиторий создает пользователя
     * @param $data
     * @return User|null
     */
    public function createUser($data)
    {
        $user = new User();
        $user->username = $data['username'];
        $user->password = $data['password'];
        if($user->save()){
            return $user;
        }
        return null;
    }

    /**
     * Репозиторий создает информацию пользователя
     * @param $data
     * @param $user_id
     * @return UserInfo
     */
    public function createUserInfo($data, $user_id)
    {
        $user_info = new UserInfo();
        $user_info->first_name = $data['first_name'];
        $user_info->last_name = $data['last_name'];
        $user_info->patronymic = $data['patronymic'];
        $user_info->email = $data['email'];
        $user_info->number_phone = $data['number_phone'];
        $user_info->birthday = $data['birthday'];
        $user_info->photo = $data['photo'];
        $user_info->user_id = $user_id;
        if($user_info->save()){
            return $user_info;
        }
        return null;
    }

    /**
     * Репозиторий создает документы пользователя
     * @param $data
     * @param $user_id
     * @return UserDocumet
     */
    public function createUserDocument($data, $user_id)
    {
        $user_document = new UserDocumet();
        $user_document->inn = $data['inn'];
        $user_document->snils = $data['snils'];
        $user_document->passport_series = $data['passport_series'];
        $user_document->passport_number = $data['passport_number'];
        $user_document->user_id = $user_id;
        if($user_document->save()){
            return $user_document;
        }
        return null;
    }

    public function getName(): string
    {
        return 'users_repository';
    }
}
