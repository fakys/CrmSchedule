<?php
namespace App\Modules\Crm\users_interface\repositories;

use App\Entity\GroupUser;
use App\Entity\UserGroup;
use App\Src\BackendHelper;
use App\Src\modules\repository\Repository;

class UserGroupsRepositories extends Repository
{
    public function getAllUsersGroup()
    {
        return UserGroup::all();
    }

    /**
     * @param $id
     * @return UserGroup
     */
    public function getUsersGroupById($id)
    {
        return UserGroup::where(['id' => $id])->first();
    }

    /**
     * Создает группу пользователей
     * @param string $name
     * @param string $access
     * @return bool
     */
    public function createUsersGroup($name, $access, $active = true, $description ='')
    {
        $group = new UserGroup();
        $group->name = $name;
        $group->accesses = $access;
        $group->active = $active;
        $group->description = $description;
        return $group->save();
    }

    /**
     * @param $user_id
     * @param $group_id
     * @return bool
     */
    public function addUserInGroup($user_id, $group_id)
    {
        $users_group = new GroupUser();
        $users_group->user_group_id = $group_id;
        $users_group->users_id = $user_id;
        return $users_group->save();
    }

    /**
     * Проверяет есть ли пользователь в группе
     * @param $user_id
     * @param $group_id
     * @return bool
     */
    public function hasUserInGroup($user_id, $group_id)
    {
        return GroupUser::where(['user_group_id' => $group_id, 'users_id' => $user_id])->exists();
    }

    /**
     * Берет все группы пользователя
     * @param $user_id
     * @return GroupUser[]
     */
    public function getUserGroupsByUserId($user_id)
    {
        return GroupUser::where(['users_id' => $user_id])->get();
    }
}
