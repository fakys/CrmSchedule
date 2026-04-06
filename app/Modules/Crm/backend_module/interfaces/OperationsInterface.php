<?php
namespace App\Modules\Crm\backend_module\interfaces;

use App\Modules\Crm\auth\components\operations\AuthOperation;
use App\Modules\Crm\schedule\src\entity\ScheduleUnit;
use App\Modules\Crm\schedule_plan\components\operation\ScheduleCardPlan;
use App\Modules\Crm\schedule_plan\components\operation\SchedulePlan;
use App\Modules\Crm\schedule_plan\components\operation\SchedulePlanSave;
use App\Modules\Crm\schedule_plan\components\operation\SchedulePlanType;
use App\Modules\Crm\schedule_plan\components\operation\ValidateSchedulePlan;
use App\Modules\Crm\student_groups\components\operations\StudentsGroupOperation;
use App\Modules\Crm\users_interface\components\operations\ValidationUserDataOperation;

/**
 * @mixin ScheduleCardPlan
 * @mixin \App\Modules\Crm\schedule\components\operations\ScheduleManagerOperation
 * @mixin \App\Modules\Crm\schedule\components\operations\ScheduleApiOperation
 * @mixin SchedulePlanType
 * @mixin \App\Modules\Crm\schedule_plan\components\operation\SchedulePlan
 * @mixin \App\Modules\Crm\schedule_plan\components\operation\ValidateSchedulePlan
 * @mixin \App\Modules\Crm\lessons\components\operations\AddLessonOperation
 * @mixin \App\Modules\Crm\schedule_plan\components\operation\SchedulePlanSave
 * @mixin ValidationUserDataOperation
 * @mixin \App\Modules\Crm\users_interface\components\operations\UsersOperation
 * @mixin \App\Modules\Crm\users_interface\components\operations\UsersGroupOperations
 * @mixin AuthOperation
 * @mixin StudentsGroupOperation
 *
 */
interface OperationsInterface
{
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

    public function checkStatusModule($name_module);

    /**
     * @return array
     * @throws \DateMalformedStringException
     */
    public function getHolidaysForTable();
}
