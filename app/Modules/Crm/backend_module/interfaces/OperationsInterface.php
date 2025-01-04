<?php
namespace App\Modules\Crm\backend_module\interfaces;

interface OperationsInterface
{
    /**
     * Добавляет пользователя в группы
     * @param $userId
     * @param $groups
     * @return true
     */
    public function addUserInGroups($userId, $groups);

    /**
     * Добавление настроек
     * @param $name
     * @return mixed
     */
    public function createSystemSettings($name);

    /**
     * Берет текущие системные настройки
     * @return mixed
     */
    public function getСurrentSystemSettings($name);

    /**
     * Возвращает все доступы пользователя по id
     * @param $user_id
     * @return array
     */
    public function getFullAccessByUserId($user_id);

    /**
     * Проверяет доступы по url
     * @param array $url
     * @return array
     */
    public function hasAccessesByUrl($url);
}
