<?php
namespace App\Modules\Crm\backend_module\interfaces;

use App\Modules\Crm\reports\operations\ReportsAbstractOperation;
use App\Modules\Crm\schedule\operations\ScheduleManagerAbstractOperation;
use App\Modules\Crm\schedule\src\entity\ScheduleUnit;
use App\Modules\Crm\users_interface\src\UserData;

/**
 * @mixin ReportsAbstractOperation
 * @mixin ScheduleManagerAbstractOperation
 */
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
     * @param $data
     * @return mixed
     */
    public function createSystemSettings($data);

    /**
     * Берет текущие системные настройки
     * @return mixed
     */
    public function getCurrentSystemSettings($name);

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

    /** Возвращает семестры для акшена */
    public function getSemesters();

    /**
     * Добавляет тип плана расписания
     * @param array $data
     * @return true
     */
    public function addSchedulePlanType($data);

    /**
     * Возвращает шаблон базового расписания
     * @param int $plan_type_id
     * @return array
     */
    public function getBaseScheduleTemplate($plan_type_id);

    /**
     * Форматирует дни недели
     * @return array
     */
    public function formatWeeks($weeks);

    /**
     * Добавляет план расписания
     * @param $data
     * @param $type_id
     * @param $group_id
     * @param $semester_id
     * @return void
     */
    public function addSchedulePlan($data, $group_id, $semester_id, $type_id);

    /**
     * Возвращает текущую неделю по дате от начала семестра
     * @param \DateTime $current_date
     * @param \DateTime $semester_start
     * @return int
     */
    public function getCurrentWeek($current_date, $semester_start, $weeks);

    public function checkStatusModule($name_module);

    /**
     * @return array
     * @throws \DateMalformedStringException
     */
    public function getHolidaysForTable();
}
