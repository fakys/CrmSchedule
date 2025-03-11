<?php

namespace App\Modules\Crm\schedule\repositories;

use App\Entity\Schedule;
use App\Entity\Semester;
use App\Modules\Crm\schedule\models\SemestersModel;
use App\Src\BackendHelper;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class SemestersRepository extends Repository
{
    /**
     * Возвращает все семестры
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSemesters()
    {
        return Semester::all();
    }

    /**
     * @param SemestersModel $model
     * @return Semester|bool
     */
    public function createSemester($model)
    {
        $semester = new Semester();
        $semester->name = $model->name;
        $semester->date_start = (new \DateTime($model->date_start))->format('Y-m-d');
        $semester->date_end = (new \DateTime($model->date_end))->format('Y-m-d');
        $semester->year_start = $model->year_start;
        $semester->year_end = $model->year_end;
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
        return Semester::where([
            ['date_start', '<=', $start->format('Y-m-d H:i:s')],
            ['date_end', '>=', $end->format('Y-m-d H:i:s')]
        ])->orderBy('year_end')->get();
    }
}
