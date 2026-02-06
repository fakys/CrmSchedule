<?php
namespace App\Modules\Crm\schedule_plan\src;

use App\Entity\SchedulePlanType;
use App\Entity\StudentGroup;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Src\BackendHelper;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelPlanSchedule implements FromArray, ShouldAutoSize
{
    const NullString = "____";
    const NullTime = "00:00";
    private $groups;

    private $plan_type;

    const GROUP_STRING = 'Номер группы:';
    const WEEK_STRING = '№Недели:';
    const PAIR_NUMBER_STRING = '№Пары';
    const USER_STRING = 'Преподаватель:';
    const SUBJECT_STRING = 'Предмет:';
    const FORMAT_STRING = 'Формат:';
    const TIME_START_STRING = 'Время начала:';
    const TIME_END_STRING = 'Время окончания:';
    const DESCRIPTION_STRING = 'Описание:';


    /**
     * @param array $groups
     * @param SchedulePlanType $plan_type
     */
    public function __construct($groups, $plan_type)
    {
        $this->groups = $groups;
        $this->plan_type = $plan_type;
    }

    public function array(): array
    {
        $excelArr = [

        ];

        $pairNumber = BackendHelper::getRepositories()->getNumberPair();
        foreach ($this->groups as $group) {
            $groupArr = [
                [self::GROUP_STRING.' '.$group['number']],
            ];

            foreach ($this->plan_type->getWeeks() as $weekNumber => $week) {
                $weekArr = array_merge([self::PAIR_NUMBER_STRING], SchedulePlanTypeModel::WEEK_DAYS);

                $groupArr = array_merge($groupArr, [
                    [self::WEEK_STRING.' '.$weekNumber],
                    $weekArr
                ]);

                foreach ($pairNumber as $number) {
                    $scheduleArr = [
                        $number->number
                    ];
                    for ($i = 0; $i < count($weekArr)-1; $i++) {
                        $scheduleArr = array_merge($scheduleArr, [
                            sprintf(
                                '%s %s; %s %s; %s %s; %s %s; %s %s; %s %s;',
                                self::USER_STRING,
                                self::NullString,
                                self::SUBJECT_STRING,
                                self::NullString,
                                self::FORMAT_STRING,
                                self::NullString,
                                self::TIME_START_STRING,
                                self::NullTime,
                                self::TIME_END_STRING,
                                self::NullTime,
                                self::DESCRIPTION_STRING,
                                self::NullString
                            ),
                        ]);
                    }
                    $groupArr[] = $scheduleArr;
                }

            }

            $excelArr = array_merge($excelArr, $groupArr);
        }

        return $excelArr;
    }
}
