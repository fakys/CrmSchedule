<?php
namespace App\Modules\Crm\lessons\repositories;

use App\Entity\DurationLesson;
use App\Entity\FormatLesson;
use App\Entity\Lesson;
use App\Entity\PairNumber;
use App\Entity\Schedule;
use App\Src\modules\repository\Repository;
use Illuminate\Support\Facades\DB;

class LessonsRepository extends Repository{

    /**
     * Возвращает все последовательности пар
     * @return mixed
     */
    public function getNumberPair()
    {
        return PairNumber::all();
    }

    /**
     * Возвращает последовательность пар по id
     * @param $id
     */
    public function getNumberPairById($id)
    {
        return PairNumber::where(['id'=>$id])->first();
    }

    /**
     * Возвращает последовательность пар по номеру
     * @param $number
     */
    public function getPairByNumber($number)
    {
        return PairNumber::where(['number'=>$number])->first();
    }

    /**
     * Создает последовательность пар
     * @param array $data
     * @return bool
     */
    public function addNumberPair($data)
    {
        $pair = new PairNumber();

        foreach($data as $key => $value){
            $pair->$key = $value;
        }
        return $pair->save();
    }

    /**
     * Обновляет последовательность пар по id
     * @param $data
     * @param $id
     * @return bool
     */
    public function updateNumberPairById($data, $id)
    {
        $pair = PairNumber::where(['id'=>$id])->first();
        if ($pair) {
            foreach($data as $key => $value){
                $pair->$key = $value;
            }
            return $pair->save();
        }
        return false;
    }

    /**
     * Удаляет последовательность пар по id
     * @param $id
     * @return bool
     */
    public function deleteNumberPairById($id)
    {
        $pair = PairNumber::where(['id'=>$id])->first();

        if ($pair) {
            return $pair->delete();
        }
        return false;
    }

    /**
     * Возвращает формат
     * @return FormatLesson[]
     */
    public function getFullFormatLessons()
    {
        return FormatLesson::all();
    }

    /**
     * Возвращает формат по id
     * @return FormatLesson[]
     */
    public function getFormatLessonsById($id)
    {
        return FormatLesson::where(['id'=>$id])->first();
    }

    /**
     * Создает длительность пары
     * @param $date_start
     * @param $time_start
     * @param $time_end
     * @param $duration_minutes
     * @return DurationLesson|null
     */
    public function createDurationLessons($date_start, $time_start, $time_end, $duration_minutes = '')
    {
        $duration = new DurationLesson();
        $duration->date_start = $date_start;
        $duration->time_start = $time_start;
        $duration->time_end = $time_end;
        $duration->duration_minutes = $duration_minutes;
        if ($duration->save()) {
            return $duration;
        }
        return null;
    }

    /**
     * Создает урок для расписания
     * @param $subject_id
     * @param $format_lesson_id
     * @param $user_id
     * @return Lesson|null
     */
    public function createLessons($subject_id, $format_lesson_id, $user_id)
    {
        $lesson= new Lesson();
        $lesson->subject_id = $subject_id;
        $lesson->format_lesson_id = $format_lesson_id;
        $lesson->user_id = $user_id;
        if ($lesson->save()) {
            return $lesson;
        }
        return null;
    }

}
