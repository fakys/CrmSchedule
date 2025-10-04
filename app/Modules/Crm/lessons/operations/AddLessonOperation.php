<?php
namespace App\Modules\Crm\lessons\operations;

use App\Entity\Lesson;
use App\Modules\Crm\lessons\models\LessonModel;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
class AddLessonOperation extends AbstractOperation
{

    /**
     * Добавляет связь предмета и преподавателя
     * @param LessonModel $model
     * @return Lesson
     */
    public function addLesson(LessonModel $model)
    {
        return BackendHelper::getRepositories()->createLessons($model->subject, $model->teacher);
    }

    public function getName(): string
    {
        return 'subject_operation';
    }
}
