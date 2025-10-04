<?php
namespace App\Modules\Crm\lessons\models;

use App\Src\BackendHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $teacher
 * @property string $subject
 */
class LessonModel extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'teacher',
            'subject'
        ];
    }

    public function rules(): array
    {
        return [
            'teacher'=>['required'],
            'subject'=>['required'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

    public function validateLesson()
    {
        return !BackendHelper::getRepositories()->checkLessonByTeacherAndSubject($this->teacher, $this->subject);
    }
}
