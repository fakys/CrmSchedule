<?php

namespace App\Modules\Crm\schedule\components\repositories;

use App\Entity\Semester;
use App\Modules\Crm\schedule\models\SemestersModel;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\modules\repository\Repository;

class SemestersRepository extends AbstractRepositories
{
    /**
     * Возвращает все семестры
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSemesters()
    {
        return Semester::all();
    }

    public function getSemestersQuery()
    {
        return Semester::query();
    }

    /**
     * @param SemestersModel $model
     * @return Semester|bool
     */
    public function createSemester($name, $date_start, $date_end, $year_start, $year_end)
    {
        $semester = new Semester();
        $semester->name = $name;
        $semester->date_start = $date_start;
        $semester->date_end = $date_end;
        $semester->year_start = $year_start;
        $semester->year_end =$year_end;
        if ($semester->save()) {
            return $semester;
        }
        return false;
    }

    /**
     * Удаляет сестер
     * @param $id
     * @return false
     */
    public function deleteSemesterById($id)
    {
        return Semester::where(['id'=>$id])->delete();
    }

    /**
     * Возвращает семестр по id
     * @param $id
     * @return mixed
     */
    public function getSemesterById($id)
    {
        return Semester::where(['id'=>$id])->first();
    }

    /**
     * Обновляет по id
     * @param $id
     * @param $field
     * @param $value
     * @return void
     */
    public function updateSemester($id, $data)
    {
        $semester = Semester::where(['id'=>$id])->first();
        foreach ($data as $field => $value) {
            $semester->$field = $value;
        }
        return $semester->save();
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return void
     */
    public function getSemestersByPeriod($start, $end)
    {
        return Semester::where(function ($query) use ($start, $end) {
            $query->whereBetween('date_start', [$start, $end])
                ->orWhereBetween('date_end', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('date_start', '<=', $start)
                        ->where('date_end', '>=', $end);
                });
        })->get();
    }

    /**
     * @param \DateTime $date
     * @return void
     */
    public function getSemestersByDate($date)
    {
        return Semester::where([
            ['date_start', '<=', $date->format('Y-m-d H:i:s')],
            ['date_end', '>=', $date->format('Y-m-d H:i:s')]
        ])->orderBy('year_end')->first();
    }

    public function getName(): string
    {
        return 'semesters_repository';
    }
}
