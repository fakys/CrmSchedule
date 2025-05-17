<?php
namespace App\Modules\Crm\reports\tasks;

use App\Entity\User;
use App\Exports\ExportExcel;
use App\Src\BackendHelper;
use App\Src\modules\task\AbstractTask;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use function Symfony\Component\Translation\t;

class ReportForGroupTask extends AbstractTask
{

    const HEADER = ['Название группы', 'Номер группы',
        'Номер специальности', 'Название специальности',
        'Название семестра', 'Количество учебных часов в периоде',
        'Среднее количество часов в неделю',
        'Количество учебных часов в семестре'];

    const FIELDS  = [
        "group_name",
        "group_number",
        "specialties_number",
        "specialties_name",
        "semester_name",
        "count_hours_period",
        "average_count_hours_week",
        "count_hours_semester",
    ];

    const REPORT_NAME = 'report_for_group';

    public static function taskName(): string
    {
        return 'report_for_group_task';
    }

    public function Execute($args = []): bool
    {
        $user_name = $args['userName'];

        $data = BackendHelper::getOperations()->getReportsForGroup(
            $args['period'], $args['students_group'] ?? [], $args['specialties'] ?? []
        );

        $main_data = [];

        /** Удаляем лишние поля */
        foreach ($data as $key=>$val) {
            foreach ($val as $k=>$v) {
                if (in_array($k, self::FIELDS)) {
                    $main_data[$key][$k] = $v;
                }
            }
        }

        array_unshift($main_data, self::HEADER);

        Excel::store(new ExportExcel(
            $main_data
        ), sprintf('reports/%s_%s.%s', self::taskName(), $user_name, ExportExcel::XLSX));

        return true;
    }

    public static function RepeatInterval()
    {
        return [];
    }

    public static function TimeZone(): string
    {
        return '';
    }

    public function getName(): string
    {
        return 'report_for_group_task';
    }
}
