<?php

namespace App\Modules\Crm\schedule\components\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class CorrectionScheduleCardOperation extends AbstractOperation
{

    /**
     * Операция возвращает название для карты
     * @param $teacherId
     * @param $subjectId
     * @param $card_id
     * @return string
     * @throws \Exception
     */
    public function getCorrectionCardName($teacherId = '', $subjectId = '', $card_id = ''): string
    {
        if (!$teacherId || !$subjectId) {
            if (!$card_id) {
                throw new \Exception('cardId не передан!');
            }
            return 'Новое расписание №'.$card_id;
        } else {
            $teacher = BackendHelper::getRepositories()->getUserById($teacherId);
            $subject = BackendHelper::getRepositories()->getSubjectById($subjectId);
            return sprintf('%s - %s', $teacher->getMinFio(), $subject->name);
        }
    }

    public function getName(): string
    {
        return 'correction_schedule_card_operation';
    }
}
