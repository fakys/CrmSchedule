<?php

namespace App\Modules\Crm\schedule_plan\components\parse_schedule\plugins;


use App\Entity\StudentGroup;
use App\Modules\Crm\schedule_plan\components\parse_schedule\ParseScheduleManager;
use App\Modules\Crm\schedule_plan\components\parse_schedule\plugins\abstracts\AbstractScheduleParsePlugin;
use App\Modules\Crm\schedule_plan\exceptions\ScheduleFileEmptyException;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;

/** Парсер стандартного расписания аквт */
class BaseScheduleParsePlugin extends AbstractScheduleParsePlugin
{
    const DAYS = 'дни';
    const HOURS = 'часы';

    const PAIRS = [
        1 => '1-2',
        2 => '3-4',
        3 => '5-6',
        4 => '7-8',
        5 => '9-10',
        6 => '11-12',
    ];

    /** @var $week_count - количество недель */
    protected $week_count;

    public function getName(): string
    {
        return 'BaseScheduleParsePlugin';
    }

    public function getTag()
    {
        return ParseScheduleManager::ManagerName;
    }

    public function setWeekCount(int $week_count)
    {
        $this->week_count = $week_count;
    }

    public function parseFileData(array $data): array
    {
        /** @var ScheduleSetting $scheduleSettings */
        $scheduleSettings = BackendHelper::getSystemSettings(ScheduleSetting::SETTING_NAME);
        $schedule = [];

        $startRowNum = null;
        $colNumHours = null;
        $allGroupInFile = $this->getAllGroups($data, $startRowNum, $colNumHours);

        if (!$allGroupInFile) {
            throw new ScheduleFileEmptyException('Файл пуст или его формат не верный!');
        }

        $pairStartArr = [];

        //Перебираем строки
        foreach ($data as $rowNum => $row) {
            if ($rowNum > $startRowNum && isset($row[$colNumHours]) && in_array(trim($row[$colNumHours]), self::PAIRS)) {
                $pairStartArr[$rowNum] = array_search(trim($row[$colNumHours]), self::PAIRS);
            }
        }

        /** todo тут не уверен что правильно, надо что-то придумать */
        $dayCount = count($pairStartArr) / max($pairStartArr);


        $weekDay = 0;
        $currentRow = null;
        foreach ($data as $rowNum => $row) {
            if ($rowNum > $startRowNum) {
                //Берем первую вару за основу
                if (!$currentRow && $rowNum === array_key_first($pairStartArr)) {
                    $currentRow = array_key_first($pairStartArr);
                }

                if ($rowNum != $currentRow && isset($pairStartArr[$rowNum])) {
                    $currentRow = $rowNum;
                    if ($pairStartArr[$currentRow] == 1)
                        $weekDay++;
                }

                if ($weekDay >= $dayCount) {
                    $weekDay = 0;
                }

                if ($currentRow) {
                    $nextPairKey = ArrayHelper::getNextKey($pairStartArr, $currentRow);
                    if ($rowNum >= $currentRow && $rowNum < $nextPairKey) {
                        foreach ($row as $collNum => $coll) {
                            if ($collNum > $colNumHours && isset($allGroupInFile[$collNum]) && $coll) {
                                $group = $allGroupInFile[$collNum]->id;

                                $resCol = trim(preg_replace('/[а-яё]{3}\.?\s*\d+/iu', '', $coll));

                                /** todo Тут что-то придумать */
                                if (mb_strtolower($resCol) == 'космонавта комарова,55') {
                                    continue;
                                }

                                if ($resCol) {
                                    $unique_fio_arr = [];
                                    for ($i = 0; $i < $this->week_count; $i++) {
                                        if ((bool)preg_match("/^[А-ЯЁA-Z][а-яёa-z-]+\s+[А-ЯЁA-Z]\.\s*[А-ЯЁA-Z]\.?$/iu", str_replace(',', '.', $resCol))) {
                                            if (empty($schedule[$group][$weekDay][$pairStartArr[$currentRow]][count($schedule[$group][$weekDay][$pairStartArr[$currentRow]]) - 1])) {
                                                /** todo Предупреждение! */
                                            }

                                            if (isset($schedule[$group][$weekDay][$pairStartArr[$currentRow]][$i]['fio'])) {
                                                if (empty($unique_fio_arr[$this->fioFormater($resCol)])) {
                                                    $unique_fio_arr[$this->fioFormater($resCol)] = true;
                                                    continue;
                                                } else {
                                                    $schedule[$group]
                                                    [$weekDay]
                                                    [$pairStartArr[$currentRow]]
                                                    [$i]
                                                    ['fio'] = $this->fioFormater($resCol);
                                                }
                                            } else {
                                                $schedule[$group]
                                                [$weekDay]
                                                [$pairStartArr[$currentRow]]
                                                [$i]
                                                ['fio'] = $this->fioFormater($resCol);
                                            }


                                        } else {
                                            $schedule
                                            [$group]
                                            [$weekDay]
                                            [$pairStartArr[$currentRow]][$i] = ['subject' => $resCol];
                                        }
                                    }

                                }
                            }
                        }
                    }
                }


            }
        }

        $return_data = [];
        $cardId =1;
        $allPairData = ArrayHelper::arrayColumnKey(BackendHelper::getRepositories()->getNumberPair(), 'number');
        foreach ($schedule as $group_id => $scheduleByGroup) {
            foreach ($scheduleByGroup as $weekDay => $scheduleByWeek) {
                foreach ($scheduleByWeek as $pairNumber => $pairsArr) {
                    foreach ($pairsArr as $weekNumber => $pairData) {

                        $subject = BackendHelper::getRepositories()->getSubjectByName($pairData['subject']);

                        if (!$subject) {
                            /** @todo Предупреждение !! */
                            $subject_id = null;
                        } else {
                            $subject_id = $subject->id;
                        }

                        $user = BackendHelper::getRepositories()->getUserByFioInInitials($pairData['fio']);

                        if (!$user) {
                            $user_id = null;
                        } else {
                            $user_id = $user->id;
                        }
                        $entity = new CardEntity(
                            $cardId,
                            BackendHelper::getOperations()->cardName($user_id, $subject_id, $cardId),
                            $pairNumber,
                            $weekDay,
                            $weekNumber + 1,
                            $group_id,
                            2,
                            1,
                            $user_id,
                            $subject_id,
                            $allPairData[$pairNumber]->time_start,
                            $allPairData[$pairNumber]->time_end,
                            '',
                            $scheduleSettings->getDefaultFormat()
                        );
                        $return_data[] = $entity;
                        $cardId++;
                    }
                }
            }
        }

        return $return_data;
    }

    /**
     * @param $data
     * @param $startRowNum
     * @param $colNumHours
     * @return StudentGroup[]
     */
    private function getAllGroups($data, &$startRowNum, &$colNumHours)
    {
        $all_group_in_file = [];

        //Перебираем строки
        foreach ($data as $rowNum => $row) {
            $prev_coll = null;
            //Перебираем колонки
            foreach ($row as $colNum => $colData) {
                //Если встречаем дни и часы - это колонка с номерами групп
                if (
                    mb_strtolower(trim($colData)) === static::HOURS && $prev_coll !== null && mb_strtolower(trim($row[$prev_coll])) === static::DAYS
                ) {
                    $startRowNum = $rowNum;
                    //Записываем колонку где стоят часы что бы понимать какая пара
                    $colNumHours = $colNum;
                    foreach ($row as $colNumGroup => $colDataGroup) {
                        if ($colNumGroup > $colNum && $colDataGroup && $groupEntity = BackendHelper::getRepositories()->searchStudentGroupByNumberOrName($colDataGroup)) {
                            //записываем все группы и их колонки
                            $all_group_in_file[$colNumGroup] = $groupEntity;
                        }
                    }
                    return $all_group_in_file;
                }
                $prev_coll = $colNum;
            }
        }

        return $all_group_in_file;
    }


}
