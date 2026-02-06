<?php
namespace App\Modules\Crm\schedule_plan\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\schedule_plan\src\ExcelPlanSchedule;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use App\Src\redis\RedisManager;

class SchedulePlan extends AbstractOperation{

    const SchedulePlanRedis = "schedule_plan_redis";

    /**
     * Добавляет план расписания
     * @param $data
     * @param $type_id
     * @param $group_id
     * @param $semester_id
     * @return void
     */
    public function addSchedulePlan($data, $group_id, $semester_id, $type_id = null)
    {
        $schedule_plan_data = BackendHelper::getRepositories()->getPlanScheduleByGroupFroManager($group_id, $semester_id);

        if (!$type_id) {
            if (!$schedule_plan_data) {
                throw new SchedulePlanAddException('Тип плана не был передан');
            }
            $type_id = $schedule_plan_data[0]->plan_type_id;
        }

        foreach ($data as$week_number=>$plan) {
            foreach ($plan as$day_number=>$day_week) {
                foreach ($day_week as $number => $pair) {
                    $schedule_edit = false;
                    foreach ($schedule_plan_data as $data_plan) {
                        if ($data_plan->week_number == $week_number && $data_plan->week_day == $day_number && $data_plan->pair_number == $number) {
                            $schedule_edit = $data_plan;
                            break;
                        }
                    }
                    $pair_number = BackendHelper::getRepositories()->getPairByNumber($number);
                    $duration_min = (new \DateTime($pair['time_end']))->diff(new \DateTime($pair['time_start']))->i;

                    /** Если надо изменить расписание */
                    if ($schedule_edit) {
                        BackendHelper::getRepositories()->updateLessons(
                            $schedule_edit->lessons_id,
                            $pair['subject_id'],
                            $pair['format_lesson_id'],
                            $pair['user_id']
                        );

                        BackendHelper::getRepositories()->updatePlanDurationLessons(
                            $schedule_edit->duration_lesson_id,
                            $day_number,
                            (new \DateTime($pair['time_start']))->format("H:i:s"),
                            (new \DateTime($pair['time_end']))->format("H:i:s"),
                            $week_number,
                            $duration_min,
                        );
                        BackendHelper::getRepositories()->updateDescriptionSchedulePlan($schedule_edit->id, $pair['schedule_description']);

                    } else {
                        /** Если надо создать расписание */
                        $duration_lessons = BackendHelper::getRepositories()->addPlanDurationLessons(
                            $day_number,
                            (new \DateTime($pair['time_start']))->format("H:i:s"),
                            (new \DateTime($pair['time_end']))->format("H:i:s"),
                            $week_number,
                            $duration_min,
                        );

                        $lessons = BackendHelper::getRepositories()
                            ->createLessons($pair['subject_id'], $pair['format_lesson_id'], $pair['user_id']);

                        if ($duration_lessons && $lessons) {
                            BackendHelper::getRepositories()->addSchedulePlan(
                                $duration_lessons->id,
                                $pair_number->id,
                                $group_id,
                                $semester_id,
                                $type_id,
                                $lessons->id,
                                $pair['schedule_description']
                            );
                        } else {
                            throw new SchedulePlanAddException('Ошибка во время создания');
                        }
                    }

                }
            }
        }
    }

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
    public function setSchedulePlanCash($data)
    {
        $redis = new RedisManager();
        $redis->redis->set(self::SchedulePlanRedis, json_encode([context()->getUser()->id => $data]), ['EX' => 3600]);
    }

    public function deleteSchedulePlanCashByUserId($user_id)
    {
        $redis = new RedisManager();
        if ($redis->redis->get(self::SchedulePlanRedis)) {
            $redis->redis->del(self::SchedulePlanRedis);
        }
    }

    public function cardName($user_id, $subject_id)
    {
        $teacher = BackendHelper::getRepositories()->getUserById($user_id);
        $subject = BackendHelper::getRepositories()->getSubjectById($subject_id);
        return sprintf('%s - %s', $teacher->getMinFio(), $subject->name);
    }

    /**
     * Возвращает ранее составленное расписание
     * @param $user_id
     * @return mixed|null
     * @throws \RedisException
     */
    public function getSchedulePlanCashByUserId($user_id)
    {
        $redis = new RedisManager();
        $json = $redis->redis->get(self::SchedulePlanRedis);
        return json_decode($json, true)[$user_id]??null;
    }

    public function uploadFileSchedulePlan($file, $semester, $plan_schedule)
    {
        $main_data = [];
        $last_pair_start_row = null;
        $pair_arr = [];
        foreach (BackendHelper::getRepositories()->getNumberPair() as $pair) {
            $pair_arr[$pair->id] = [];
        }
        foreach ($file as $key=>$data) {
            if (strpos($data['A'], ExcelPlanSchedule::GROUP_STRING) !== false) { //Если мы находим группу, добавляем её в массив
                $group = BackendHelper::getRepositories()->getStudentGroupByName(trim(str_replace(ExcelPlanSchedule::GROUP_STRING, '', $data['A'])));
                if (!$group) {
                    throw new SchedulePlanAddException('Группа '.trim(str_replace(ExcelPlanSchedule::GROUP_STRING, '', $data['A'])) .' не найдена');
                }
                $main_data[$group[0]->id] = [];
            }
            if (strpos($data['A'], ExcelPlanSchedule::WEEK_STRING) !== false) {
                //закидываем в последнюю группу
                $main_data[array_key_last($main_data)][trim(str_replace(ExcelPlanSchedule::WEEK_STRING, '', $data['A']))] = [];
            }
            if ($data['A'] === ExcelPlanSchedule::PAIR_NUMBER_STRING) {
                $last_pair_start_row = $data;
                continue;
            }

            if ($last_pair_start_row && $last_pair_start_row['A'] === ExcelPlanSchedule::PAIR_NUMBER_STRING) { //Значит далее идет расписание
                try {
                    if (
                        isset($main_data[array_key_last($main_data)][array_key_last($main_data[array_key_last($main_data)])])
                    ) {
                        if (
                            isset($main_data[array_key_last($main_data)][array_key_last($main_data[array_key_last($main_data)])])
                        ) {
                            foreach (SchedulePlanTypeModel::WEEK_DAYS as $week_number => $week) {
                                $main_data[array_key_last($main_data)][array_key_last($main_data[array_key_last($main_data)])][$week_number] = $pair_arr;
                            }
                        }
                    }
                } catch (\Throwable $throwable) {
                    dd($data);
                }


                foreach ($main_data[array_key_last($main_data)][array_key_last($main_data[array_key_last($main_data)])] as $week_day => $week_day_data) {
                    if (!$week_day_data[array_key_last($week_day_data)]) {
                        break;
                    }
                }

                $pair_number = trim($data['A']);
                unset($data['A']);
                foreach ($main_data[array_key_last($main_data)][array_key_last($main_data[array_key_last($main_data)])] as $day => $day_data) {
                    $string_exel = $data[array_key_first($data)];

                    $user_id = null;
                    $user_str = $this->parseFileData(ExcelPlanSchedule::USER_STRING, $string_exel);
                    if ($user_str) {
                        $user = BackendHelper::getRepositories()->getFullUsersInfoSearch(['fio' => $user_str]);
                        if (!$user) {
                            throw new SchedulePlanAddException('Пользователь по ФИО '.$user_str.' не найден');
                        }
                        $user_id = $user[0]->id;
                    }

                    $subject_id = null;
                    $subject_str = $this->parseFileData(ExcelPlanSchedule::SUBJECT_STRING, $string_exel);
                    if ($subject_str) {
                        $subject = BackendHelper::getRepositories()->getSearchSubjectInfo(['name' => $subject_str]);
                        if (!$subject) {
                            throw new SchedulePlanAddException('Предмет по названию '.$this->parseFileData(ExcelPlanSchedule::SUBJECT_STRING, $string_exel).' не найден');
                        }
                        $subject_id = $subject[0]->id;
                    }


                    $format_id = null;
                    $format_str = $this->parseFileData(ExcelPlanSchedule::FORMAT_STRING, $string_exel);
                    if ($format_str) {
                        $format = BackendHelper::getRepositories()->getFormatLessonsByName($format_str);
                        if (!$format) {
                            throw new SchedulePlanAddException('Формат по названию '.$format_str.' не найден');
                        }
                        $format_id = $format->id;
                    }


                    $arr_schedule_data = [
                        'user' => $user_id,
                        'subject' => $subject_id,
                        'format' => $format_id,
                        'time_start' => $this->parseFileData(ExcelPlanSchedule::TIME_START_STRING, $string_exel),
                        'time_end' => $this->parseFileData(ExcelPlanSchedule::TIME_END_STRING, $string_exel),
                        'description' => $this->parseFileData(ExcelPlanSchedule::DESCRIPTION_STRING, $string_exel),
                        'cardName' => $user_id && $subject_id ? $user_str .' - '.$subject_str: null,
                    ];

                    $main_data[array_key_last($main_data)]
                    [array_key_last($main_data[array_key_last($main_data)])][$day]
                    [$pair_number] = $arr_schedule_data;
                    unset($data[array_key_first($data)]);
                }
            }
        }

        return $this->formatForCard($main_data, $semester, $plan_schedule);
    }

    private function formatForCard($data, $semester, $plan_schedule)
    {
        $main_data = [];
        foreach ($data as $group_id=>$group_data) {
            foreach ($group_data as $week_number=>$week_data) {
                foreach ($week_data as $day=>$day_data) {
                    foreach ($day_data as $pair_number=>$pair_data) {
                        $main_data[] = array_merge([
                            'weekDay' => $day - 1,
                            'weekNumber' => $week_number,
                            'numberPair' => $pair_number,
                            'group' => $group_id,
                            'semester' => $semester
                        ],$pair_data);

                    }
                }
            }
        }
        return $main_data;
    }

    private function parseFileData($field, $string)
    {
        preg_match(sprintf('/%s\s*([^;]+)/', $field), $string, $subject_arr);
        if ($subject_arr[1] != ExcelPlanSchedule::NullString && $subject_arr[1] != ExcelPlanSchedule::NullTime) {
            return $subject_arr[1];
        }
        return null;
    }

    public function getName(): string
    {
        return 'schedule_plan_operation';
    }
}
