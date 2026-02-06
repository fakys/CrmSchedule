<?php
namespace App\Modules\Crm\lessons\repositories;

use App\Entity\DurationLesson;
use App\Entity\FormatLesson;
use App\Entity\Lesson;
use App\Entity\PairNumber;
use App\Entity\ScheduleTask;
use App\Src\modules\repository\AbstractRepositories;
use Illuminate\Support\Facades\DB;

class LessonsRepository extends AbstractRepositories{

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
     * @return FormatLesson
     */
    public function getFormatLessonsById($id)
    {
        return FormatLesson::where(['id'=>$id])->first();
    }

    /**
     * Возвращает формат по id
     * @return FormatLesson
     */
    public function getFormatLessonsByName($name)
    {
        return FormatLesson::where(['name'=>$name])->first();
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
     * @param $id
     * @return Lesson
     */
    public function getLessonsById($id)
    {
        return Lesson::where(['id'=>$id])->first();
    }

    /**
     * @param $user_id
     * @return Lesson[]
     */
    public function getLessonsByUser($user_id)
    {
        return Lesson::where(['user_id'=>$user_id])->get();
    }

    public function setLesson($lesson)
    {
        return $lesson->save();
    }

    public function getAllLessonsInfo()
    {
        $sql = "select
                    lessons.id,
                    users_info.first_name || ' ' || users_info.last_name || ' ' || users_info.patronymic as fio,
                    subject.name as subject_name,
                    subject.full_name as subject_full_name
                from lessons
                    join subjects subject on subject.id = lessons.subject_id
                    join users_info users_info on users_info.user_id = lessons.user_id";

        return DB::select(
            $sql,
            []
        );
    }

    public function getAllLessonsInfoById($id)
    {
        $sql = "select
                    lessons.id,
                    users_info.first_name || ' ' || users_info.last_name || ' ' || users_info.patronymic as fio,
                    subject.name as subject_name,
                    subject.full_name as subject_full_name
                from lessons
                    join subjects subject on subject.id = lessons.subject_id
                    join users_info users_info on users_info.user_id = lessons.user_id
                where lessons.id = :id";

        return DB::selectOne(
            $sql,
            [':id' => $id]
        );
    }

    /**
     * Создает урок для расписания
     * @param $subject_id
     * @param $user_id
     * @return Lesson|null
     */
    public function createLessons($subject_id, $user_id)
    {
        $lesson= new Lesson();
        $lesson->subject_id = $subject_id;
        $lesson->user_id = $user_id;
        if ($lesson->save()) {
            return $lesson;
        }
        return null;
    }

    public function checkLessonByTeacherAndSubject($teacher, $subject)
    {
        return Lesson::where(['subject_id' => $subject, 'user_id' => $teacher])->count();
    }

    public function getLessonByTeacherAndSubject($teacher, $subject)
    {
        return Lesson::where(['subject_id' => $subject, 'user_id' => $teacher])->first();
    }

    /**
     * Обновление урок для расписания
     * @param $id
     * @param $subject_id
     * @param $format_lesson_id
     * @param $user_id
     * @return Lesson|null
     */
    public function updateLessons($id, $subject_id, $format_lesson_id, $user_id)
    {
        $lesson = Lesson::where(['id'=>$id])->first();
        $lesson->subject_id = $subject_id;
        $lesson->format_lesson_id = $format_lesson_id;
        $lesson->user_id = $user_id;
        if ($lesson->save()) {
            return $lesson;
        }
        return null;
    }

    public function getName(): string
    {
        return 'lessons_repository';
    }
}
