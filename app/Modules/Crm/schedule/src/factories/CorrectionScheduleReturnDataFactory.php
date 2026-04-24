<?php

namespace App\Modules\Crm\schedule\src\factories;

use App\Modules\Crm\schedule\src\entity\CorrectionCardEntity;
use App\Modules\Crm\schedule\src\returnData\CorrectionScheduleGroupReturnData;
use App\Modules\Crm\schedule\src\returnData\CorrectionScheduleReturnData;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;
use App\Src\BackendHelper;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\DateTime;

class CorrectionScheduleReturnDataFactory
{
    public static function createSchedule(array $data)
    {
        $groupArr = [];
        $cardCount = 1;
        foreach ($data as $groupId => $group) {
            $cardArr = [];
            foreach ($group as $cardData) {
                /** @var ScheduleUnit $cardData */
                $cardArr[] = new CorrectionCardEntity(
                    $cardCount,
                    BackendHelper::getOperations()->CorrectionScheduleCardOperation($cardData->getUser(), $cardData->getSubject()),
                    $cardData->getPairNumber(),
                    $cardData->getUser(),
                    $cardData->getSubject(),
                    '',
                    ''
                );
                $cardCount++;
            }

            $groupEntity = BackendHelper::getRepositories()->getStudentGroupById($groupId);
            $groupArr[] = new CorrectionScheduleGroupReturnData($groupEntity->id, $groupEntity->name, $cardArr);
        }

        return new CorrectionScheduleReturnData($groupArr);
    }
}
