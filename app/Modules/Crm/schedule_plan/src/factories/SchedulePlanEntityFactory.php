<?php
namespace App\Modules\Crm\schedule_plan\src\factories;

use App\Modules\Crm\schedule_plan\src\CardEntity;

class SchedulePlanEntityFactory {
    public static function createSchedulePlanEntity(array $data): CardEntity
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
            $data['errorMessage'],
            $data['warningMessage']
        );
    }
}
