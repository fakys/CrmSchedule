<?php
namespace App\Modules\Crm\backend_module\interfaces;

use App\Entity\GroupUser;
use App\Entity\User;
use App\Entity\UserGroup;

interface RepositoryInterface{
    /**
     * Возвращает пользователей по условию
     * @param $data
     * @return User[]
     */
    public function getUserList($data);

    /**
     * Возвращает расширенную информацию по пользователю
     * @return mixed
     */
    public function getFullUsersInfo();

    /**
     * Возвращает пользователя по id
     * @param $id
     * @return User
     */
    public function getUserById($id);

    /**
     * Обновляет пользователя по id
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateUsersById($id, $data);

    /**
     * Обновляет информацию по пользователю по id
     * @param $id
     * @param $value
     * @return bool
     */
    public function updateUsersInfoById($id, $value);

    /**
     * Обновляет документы пользователя по id
     * @param $id
     * @param $value
     * @return bool
     */
    public function updateUsersDocumentById($id, $value);

    /**
     * Обновляет доступ(Логин и пароль) пользователя по id
     * @param $id
     * @param $value
     * @return bool
     */
    public function saveAccessUser($id, $model);

    /**
     * Добавляет пользователя в группу
     * @param $user_id
     * @param $group_id
     * @return mixed
     */
    public function addUserInGroup($user_id, $group_id);

    /**
     * Возвращает группу пользователей по id
     * @param $id
     * @return UserGroup
     */
    public function getUsersGroupById($id);

    /**
     * Проверяет есть ли пользователь в группе
     * @param $user_id
     * @param $group_id
     * @return bool
     */
    public function hasUserInGroup($user_id, $group_id);

    /**
     * Берет все группы пользователя
     * @param $user_id
     * @return GroupUser[]
     */
    public function getUserGroupsByUserId($user_id);
}
