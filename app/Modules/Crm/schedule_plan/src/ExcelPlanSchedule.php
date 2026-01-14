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
                ['Номер группы: '.$group['number']],
            ];

            foreach ($this->plan_type->getWeeks() as $weekNumber => $week) {
                $weekArr = SchedulePlanTypeModel::WEEK_DAYS;
                array_unshift($weekArr, '');
                $groupArr = array_merge($groupArr, [
                    ['№Недели: '.$weekNumber],
                    $weekArr
                ]);

                foreach ($pairNumber as $number) {
                    $scheduleArr = [
                        $number->number
                    ];
                    for ($i = 0; $i < count($weekArr)-1; $i++) {
                        $scheduleArr = array_merge($scheduleArr, [
                            sprintf(
                                'Преподаватель: %s; Предмет: %s; Формат: %s; Время начала: %s; Время окончания: %s; Описание: %s;',
                                self::NullString,
                                self::NullString,
                                self::NullString,
                                self::NullTime,
                                self::NullTime,
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
