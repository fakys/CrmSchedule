<?php
namespace App\Modules\Crm\backend_module\interfaces;

use App\Modules\Crm\schedule\src\entity\ScheduleUnit;
use App\Modules\Crm\users_interface\src\UserData;

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

    /**
     * Операция добавляет пользователя
     * @param $data
     * @return UserData
     * @throws \Exception
     */
    public function addUser($data);

    /**
     * Возвращает не добавленные модули
     * @return array
     */
    public function getDataModuleInNotStatusModules();

    /**
     * Возвращает расписание для менеджера расписаний
     * @param $data
     * @return array
     */
    public function getScheduleData($data);

    /**
     * Возвращает период
     * @param $period
     * @return \DateTime[]
     */
    public function pacePeriod($period);


    /**
     * Редактирует расписание
     * @param $newSchedule
     * @return bool
     *
     */
    public function editSchedule($newSchedule, $searchData);

    /**
     * Сохраняет новое расписание по старым данным
     * @param $unit
     * @param $data_report
     * @return void
     */
    public function saveSchedule($unit);

    /**
     * @param $new_data
     * @param $old_data
     * @param $entity
     * @return void
     */
    public function checkScheduleData($new_data, $old_data, $name_field, $entity);

    /**
     * Создает расписание
     * @param ScheduleUnit $unit
     * @return bool
     */
    public function createSchedule($unit);
}
