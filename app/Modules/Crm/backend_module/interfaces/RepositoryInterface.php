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
    public function getGroupsUserByUserId($user_id);

    /**
     * Возвращает группы пользователей по id
     * @param $id
     * @return UserGroup
     */
    public function getUsersGroupById($id);

    /**
     * Создает группу пользователей
     * @param string $name
     * @param string $access
     * @return bool
     */
    public function updateUserGroup($group_id, $name, $access, $active = true, $description = '');

    /**
     * Создает группу пользователей
     * @param string $name
     * @param string $access
     * @return bool
     */
    public function createUsersGroup($name, $access, $active = true, $description ='');

    /**
     * Удаляет группу пользователей по id
     * @param $id
     * @return bool|null
     */
    public function deleteUserGroupById($id);

    /**
     * Возвращает все группы пользователей
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsersGroup();

    /**
     * Возвращает всех активных пользователей
     * @return \Illuminate\Database\Eloquent\Collect
     */
    public function getAllActiveUsers();

    /**
     * возвращает актуальные настройки системы
     * @param $name
     * @return mixed
     */
    public function getActiveSystemSettings($name);

    /**
     * возвращает последние настройки системы
     * @param $name
     * @return mixed
     */
    public function getLastSystemSettings($name);

    /**
     * делает переданные настройки актуальными
     * @param $settings
     * @return mixed
     */
    public function saveActiveSystemSettings($settings);
}
