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
}
