<?php

namespace App\Modules\Crm\schedule\components\repositories;

use App\Entity\Schedule;
use App\Modules\Crm\schedule\Entity\CorrectionSchedule;
use App\Src\modules\repository\AbstractRepositories;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CorrectionScheduleRepository extends AbstractRepositories
{
    /**
     * Возвращает расписание по группе за дату
     * @param $group_id
     * @param $date_start
     * @param $date_end
     * @return mixed
     */
    public function getCorrectionScheduleByGroupAndDate($group_id, $date_start, $date_end)
    {

        $schedule = CorrectionSchedule::query()->with('schedule')->whereHas(
            'schedule',
            function ($query) use ($group_id) {
                $query->whereIn('student_group_id', $group_id);
            }
        )
            ->where('date_start', '>=', $date_start)
            ->where('date_start', '<=', $date_end);
        return $schedule->get();
    }

    public function getName(): string
    {
        return 'correction_schedule_repository';
    }
}
