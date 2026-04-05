<?php

namespace App\Modules\Crm\schedule_plan\components\operation;

use App\Modules\Crm\schedule_plan\exceptions\SchedulePlanAddException;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Modules\Crm\schedule_plan\src\ExcelPlanSchedule;
use App\Modules\Crm\schedule_plan\src\schedule_parse\ScheduleParseReturnData;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
use App\Src\redis\RedisManager;

class ScheduleCardPlan extends AbstractOperation
{
    public function getName(): string
    {
        return 'schedule_plan_operation';
    }

    public function convertDataToCardEntity(array $data): CardEntity
    {
        return new CardEntity(
            $data['cardId'],
            $data['cardName'],
            $data['numberPair'],
            $data['weekDay'],
            $data['weekNumber'],
            $data['groupId'],
            $data['planTypeId'],
            $data['semesterId'],
            $data['teacherId'],
            $data['subjectId'],
            $data['timeStart'],
            $data['timeEnd'],
            $data['description'],
            $data['formatId'],
        );
    }

    public function convertDataToCardsEntities(array $data): array
    {
        $cards = [];
        foreach ($data as $card) {
            $cards[] = $this->convertDataToCardEntity($card);
        }

        return $cards;
    }


    public function cardName($user_id, $subject_id)
    {
        $teacher = BackendHelper::getRepositories()->getUserById($user_id);
        $subject = BackendHelper::getRepositories()->getSubjectById($subject_id);
        return sprintf('%s - %s', $teacher->getMinFio(), $subject->name);
    }
}
