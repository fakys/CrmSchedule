<?php
namespace App\Modules\Crm\lessons\components\operations;

use App\Entity\Lesson;
use App\Modules\Crm\lessons\models\LessonModel;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class AddLessonOperation extends AbstractOperation
{
    public function getName(): string
    {
        return 'subject_operation';
    }
}
