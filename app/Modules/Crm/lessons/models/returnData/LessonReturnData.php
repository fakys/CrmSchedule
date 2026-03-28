<?php
namespace App\Modules\Crm\lessons\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class LessonReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('subject')]
    private $subject;

    #[ReturnDataFieldAttribute('teacher')]
    private $teacher;

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTeacher(): string
    {
        return $this->teacher;
    }

    public function toArray(): array
    {
        return [
            'subject' => $this->getSubject(),
            'teacher' => $this->getTeacher(),
        ];
    }
}
