<?php
namespace App\Modules\Crm\schedule_plan\components\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;
use App\Modules\Crm\schedule_plan\src\factories\SchedulePlanReturnDataFactory;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use App\Src\redis\RedisManager;

class SchedulePlan extends AbstractOperation{

    const SchedulePlanRedis = "schedule_plan_redis";

    /**
     * Возвращает текущую неделю по дате от начала семестра
     * @param \DateTime $current_date
     * @param \DateTime $semester_start
     * @return int
     */
    public function getCurrentWeek($current_date, $semester_start, $weeks)
    {
        $count_week = floor($current_date->diff($semester_start)->days/7);
        if (!$count_week) {
            $count_week = 1;
        }
        return (($count_week-1)%$weeks)+1;
    }

    public function validateFieldPlan($pair_data, $semester_id, $exception = [])
    {
        $all_plans = BackendHelper::getRepositories()->getAllSchedulePlanBySemester($semester_id);
        $return_data = [];
        foreach ($all_plans as $data) {
            if (!in_array($data->id, $exception)) {
                $duration = $data->getDuration();
                $pairNumber = $data->getPairNumber();
                $lessons = $data->getLesson();
                if (
                    $pairNumber &&
                    $pairNumber->number == $pair_data['pair_number'] &&
                    $duration &&
                    $duration->week_number == $pair_data['week_number'] &&
                    $duration->week_day == $pair_data['week_day'] &&
                    $lessons &&
                    $lessons->user_id == $pair_data['user_id']
                ) {
                    $user = $lessons->getUser();
                    $return_data[] = sprintf("Преподаватель %s уже занят Неделя №%s День №%s Пара №%s", $user->getFio(), $duration->week_number, $duration->week_day, $pairNumber->number);
                }
            }
        }


        return $return_data;
    }

    /**
     * Если пользователь не до конца заполнил расписание, сохраняем его в кеш на 1 час
     * @return void
     */
    public function setSchedulePlanCash(SchedulePlanReturnData $data)
    {
        /** todo сделать настройку на время жизни */
        $redis = new RedisManager();
        $redis->redis->set(self::SchedulePlanRedis, json_encode([BackendHelper::getKernel()->getContext()->getUser()->id => $data->toArray()]), ['EX' => 3600]);
    }

    public function setSchedulePlanCashForUser(SchedulePlanReturnData $data, $userId)
    {
        /** todo сделать настройку на время жизни */
        $redis = new RedisManager();
        $redis->redis->set(self::SchedulePlanRedis, json_encode([$userId => $data->toArray()]), ['EX' => 3600]);
    }

    public function deleteSchedulePlanCashByUserId()
    {
        $redis = new RedisManager();
        /** todo удалять только нужного пользователя */
        if ($redis->redis->get(self::SchedulePlanRedis)) {
            $redis->redis->del(self::SchedulePlanRedis);
        }
    }

    /**
     * Возвращает ранее составленное расписание
     * @param $user_id
     * @return SchedulePlanReturnData|null
     * @throws \RedisException
     */
    public function getSchedulePlanCashByUserId($user_id)
    {
        $redis = new RedisManager();
        $json = $redis->redis->get(self::SchedulePlanRedis);
        if (isset(json_decode($json, true)[$user_id])) {
            return SchedulePlanReturnDataFactory::createCashSchedulePlanEntity(json_decode($json, true)[$user_id]);
        }
        return null;
    }

    /**
     * @param CardEntity[] $parseData
     * @param int $plan_schedule_id
     * @param array $groups
     * @return array
     */
    public function cardEntityConvertToArray(array $parseData, $plan_schedule_id, array $groups)
    {
        $main_data = [];
        $plan_schedule = BackendHelper::getRepositories()->getSchedulePlanTypeById($plan_schedule_id);
        $weeks = $plan_schedule->getWeeks();
        foreach ($parseData as $entity) {
            if (in_array($entity->getGroupId(), $groups) && isset($weeks[$entity->getWeekNumber()])) {
                $main_data[] = $entity->toArray();
            }
        }

        return $main_data;
    }

    public function getName(): string
    {
        return 'schedule_plan_operation';
    }
}
