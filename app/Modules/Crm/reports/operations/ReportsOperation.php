<?php
namespace App\Modules\Crm\reports\operations;

use App\Exports\ExportExcel;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;
use Illuminate\Support\Facades\Storage;

class ReportsOperation extends Operation {

    /** Операция возвращает данные для отчета по группам */
    public function getReportsForGroup($period, $group = [], $specialties = [])
    {
        $manager = BackendHelper::getManager('schedule_manger');
        $manager->setAttr(['search_data'=>['period'=> $period, 'groups'=> $group, 'specialties'=> $specialties]]);
        $manager->Execute();
        /** @var ScheduleUnit[] $units */
        $units = $manager->getResult()->getScheduleUnits();
        $main_data = [];
        $hours_arr = [];

        //Считаем часы за период
        foreach ($units as $unit) {
            if ($unit->getTimeStart() && $unit->getTimeEnd()) {

                $hours = 0;
                $diff = $unit->getTimeStart()->diff($unit->getTimeEnd());
                $count_minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
                if ($count_minutes > 0) {

                    if (isset($hours_arr[$unit->getSemester()][$unit->getGroup()]['hour_period_count'])) {
                        $hours = $hours_arr[$unit->getSemester()][$unit->getGroup()]['hour_period_count'];
                    } else {
                        $group = BackendHelper::getRepositories()->getStudentGroupById($unit->getGroup());
                        $semester = BackendHelper::getRepositories()->getSemesterById($unit->getSemester());
                        $specialties = $group->getSpecialty();

                        $main_data[] = [
                            'semester_start' => $semester->date_start, 'semester_end' => $semester->date_end,
                            'group_id'=>$unit->getGroup(), 'semester_id'=>$unit->getSemester(),
                            'group_name'=>$group->name, 'group_number'=>$group->number,
                            'specialties_number'=>$specialties->number, 'specialties_name'=>$specialties->name,
                            'semester_name'=>$semester->name,'count_hours_period'=>0,
                            'average_count_hours_week'=>0,
                            'count_hours_semester'=>0
                        ];
                    }

                    $hour_unit = ceil($unit->getTimeStart()->diff($unit->getTimeEnd())->i / 60);
                    $hours_arr[$unit->getSemester()][$unit->getGroup()]['hour_period_count'] = $hours + $hour_unit;
                    $main_data[$this->getDateByGroupAndSemester($unit->getGroup(), $unit->getSemester(), $main_data)]['count_hours_period'] = $hours + $hour_unit;
                }
            }
        }


        foreach ($main_data as $data) {
            $manager = BackendHelper::getManager('schedule_manger');
            $manager->setAttr(['search_data'=>[
                'period'=>(new \DateTime($data['semester_start']))->format('Y-m-d').' - '.(new \DateTime($data['semester_end']))->format('Y-m-d'),
                'groups'=>[$data['group_id']], 'specialties' => []]]);
            $manager->Execute();
            /** @var ScheduleUnit[] $units */
            $units = $manager->getResult()->getScheduleUnits();
            $semester_hours = 0;
            foreach ($units as $unit) {
                if ($unit->getTimeStart() && $unit->getTimeEnd()) {
                    $hour_unit = ceil($unit->getTimeStart()->diff($unit->getTimeEnd())->i / 60);
                    $semester_hours += $hour_unit;
                }
            }
            $main_data[$this->getDateByGroupAndSemester($data['group_id'], $data['semester_id'], $main_data)]['count_hours_semester'] = $semester_hours;

            $week_count = ceil((new \DateTime($data['semester_start']))->diff(new \DateTime($data['semester_end']))->days/7);
            $main_data[$this->getDateByGroupAndSemester($data['group_id'], $data['semester_id'], $main_data)]['average_count_hours_week']
                = round($semester_hours / $week_count, 2);
        }
        return $main_data;
    }

    private function getDateByGroupAndSemester($group, $semester, $main_data)
    {
        foreach ($main_data as $key=>$data) {
            if ($data['group_id'] == $group && $data['semester_id'] == $semester) {
                return $key;
            }
        }
        return null;
    }

    public function getReportsForTeachers($period, $teachers = [])
    {
        $manager = BackendHelper::getManager('schedule_manger');
        $manager->setAttr(['search_data'=>['period'=> $period]]);
        $manager->Execute();
        /** @var ScheduleUnit[] $units */
        $units = $manager->getResult()->getScheduleUnits();
        $main_data = [];
        $hours_arr = [];

        //Считаем часы за период
        foreach ($units as $unit) {
            if (
                $unit->getTimeStart() && $unit->getTimeEnd() &&
                $teachers && $unit->getUser() && in_array($unit->getUser(), $teachers)
            ) {
                $hours = 0;
                $diff = $unit->getTimeStart()->diff($unit->getTimeEnd());
                $count_minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
                if ($count_minutes > 0) {

                    if (isset($hours_arr[$unit->getSemester()][$unit->getUser()]['hour_period_count'])) {
                        $hours = $hours_arr[$unit->getSemester()][$unit->getUser()]['hour_period_count'];
                    } else {
                        $semester = BackendHelper::getRepositories()->getSemesterById($unit->getSemester());
                        $user = BackendHelper::getRepositories()->getUserById($unit->getUser());

                        $main_data[] = [
                            'semester_start' => $semester->date_start, 'semester_end' => $semester->date_end,
                            'user_name' => $user->username,
                            'user_id'=>$unit->getUser(), 'semester_id'=>$unit->getSemester(),
                            'fio'=>$unit->getUserFio(),
                            'semester_name'=>$semester->name,'count_hours_period'=>0,
                            'average_count_hours_week'=>0,
                            'count_hours_semester'=>0
                        ];
                    }

                    $hour_unit = ceil($unit->getTimeStart()->diff($unit->getTimeEnd())->i / 60);
                    $hours_arr[$unit->getSemester()][$unit->getUser()]['hour_period_count'] = $hours + $hour_unit;
                    $main_data[$this->getDateByTeachearsAndSemester($unit->getUser(), $unit->getSemester(), $main_data)]['count_hours_period'] = $hours + $hour_unit;
                }
            }
        }

        foreach ($main_data as $data) {
            $manager = BackendHelper::getManager('schedule_manger');
            $manager->setAttr(['search_data'=>[
                'period'=>(new \DateTime($data['semester_start']))->format('Y-m-d').' - '.(new \DateTime($data['semester_end']))->format('Y-m-d'),
                'groups'=>[], 'specialties' => []]]);
            $manager->Execute();
            /** @var ScheduleUnit[] $units */
            $units = $manager->getResult()->getScheduleUnits();
            $semester_hours = 0;
            foreach ($units as $unit) {
                if ($unit->getTimeStart() && $unit->getTimeEnd()) {
                    $hour_unit = ceil($unit->getTimeStart()->diff($unit->getTimeEnd())->i / 60);
                    $semester_hours += $hour_unit;
                }
            }
            $main_data[$this->getDateByTeachearsAndSemester($data['user_id'], $data['semester_id'], $main_data)]['count_hours_semester'] = $semester_hours;

            $week_count = ceil((new \DateTime($data['semester_start']))->diff(new \DateTime($data['semester_end']))->days/7);
            $main_data[$this->getDateByTeachearsAndSemester($data['user_id'], $data['semester_id'], $main_data)]['average_count_hours_week']
                = round($semester_hours / $week_count, 2);
        }
        return $main_data;
    }

    private function getDateByTeachearsAndSemester($group, $semester, $main_data)
    {
        foreach ($main_data as $key=>$data) {
            if ($data['user_id'] == $group && $data['semester_id'] == $semester) {
                return $key;
            }
        }
        return null;
    }

    /**
     * Проверяет создался ли таск
     * @param $task_name
     * @param $user_name
     * @return false|string
     */
    public function checkExportTask($task_name, $user_name)
    {
        if (BackendHelper::getRepositories()->hasActiveTask($task_name, $user_name)){
            return 'created';
        } elseif (Storage::has(sprintf('reports/%s_%s.%s', $task_name, $user_name, ExportExcel::XLSX))){
            return 'done';
        }

        return false;
    }
}
