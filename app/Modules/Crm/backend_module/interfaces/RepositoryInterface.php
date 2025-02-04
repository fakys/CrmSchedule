<?php
namespace App\Modules\Crm\backend_module\interfaces;

use App\Entity\GroupUser;
use App\Entity\Specialty;
use App\Entity\StudentGroup;
use App\Entity\Subject;
use App\Entity\User;
use App\Entity\UserDocumet;
use App\Entity\UserGroup;
use App\Entity\UserInfo;

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

    /**
     * Репозиторий создает пользователе
     * @param $data
     * @return User|null
     */
    public function createUser($data);

    /**
     * Репозиторий создает информацию пользователя
     * @param $data
     * @param $user_id
     * @return UserInfo|null
     */
    public function createUserInfo($data, $user_id);

    /**
     * Репозиторий создает документы пользователя
     * @param $data
     * @param $user_id
     * @return UserDocumet|null
     */
    public function createUserDocument($data, $user_id);

    /**
     * Выдает информацию по пользователю с поиском
     * @param $data
     * @return array
     */
    public function getFullUsersInfoSearch($data);

    /**
     * Создание специальности
     * @return Specialty|null
     */
    public function createSpecialty($number, $name, $description = '');

    /**
     * Возвращает все специальности
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSpecialties();


    /**
     * Создание студенческой группы
     * @return StudentGroup|null
     */
    public function createStudentGroup($number, $name, $specialty_id = '');

    /**
     * Создает предмет
     * @param $name
     * @param $full_name
     * @param $description
     * @return Subject|null
     */
    public function createSubject($name, $full_name, $description = '');

    /**
     * Возвращает все группы со специальностями
     * @return array
     */
    public function getStudentGroupsInfo();

    /**
     * Поиск групп студентов
     * @return array
     */
    public function searchStudentGroups($data);

    /**
     * Возвращает предметы для таблицы
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubjectInfo();

    /**
     * Получает группу студентов то id
     * @param $id
     * @return StudentGroup
     */
    public function getStudentGroupById($id);


    /**
     * Обновляет группу студентов по id
     * @param int $id id группы студентов
     * @param string $field название поля
     * @param mixed $value содержимое поля
     * @return bool
     */
    public function updateStudentGroupById($id, $field, $value);

    /**
     * Обновляет специальность по id
     * @param $id
     * @param $field
     * @param $value
     * @return mixed
     */
    public function updateSpecialtyByStudentGroupId($id, $field, $value);
}
