<?php

namespace App\Modules\Crm\schedule_plan\components\operation;

use App\Entity\Lesson;
use App\Entity\Schedule;
use App\Modules\Crm\schedule_plan\src\CardEntity;
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


    public function cardName($user_id = null, $subject_id = null, $card_id = null)
    {
        if (!$user_id || !$subject_id) {
            if (!$card_id) {
                throw new \Exception('cardId не передан!');
            }
            return 'Новое расписание №'.$card_id;
        } else {
            $teacher = BackendHelper::getRepositories()->getUserById($user_id);
            $subject = BackendHelper::getRepositories()->getSubjectById($subject_id);
            return sprintf('%s - %s', $teacher->getMinFio(), $subject->name);
        }
    }

    public function formatScheduleCardsData($card_data, $groups, $planType, $semester, $specialties)
    {
        $data = [
            'schedule_data' => $card_data,
            'groups' => $groups,
            'semester' => $semester,
            'specialties' => $specialties,
            'plan_type' => $planType,
        ];
        return $data;
    }

    public function getPlanScheduleByGroupsCardFormatArray($groups_id, $semester_id): array
    {
        $data = [];
        $schedule_data_db = BackendHelper::getRepositories()->getPlanScheduleByGroups($groups_id, $semester_id);

        foreach ($schedule_data_db as $key => $schedulePlan) {
            /** @var Schedule $schedule */
            $schedule = $schedulePlan->schedule()->first();
            /** @var Lesson $lesson */
            $lesson = $schedule->getLesson();
            $pairNumber = $schedule->getPairNumber();
            $duration = $schedule->getDuration();

            $card = new CardEntity(
                $key+1,
                BackendHelper::getOperations()->cardName($lesson->user_id, $lesson->subject_id),
                $pairNumber->number,
                $schedulePlan->week_day,
                $schedulePlan->week_number,
                $schedule->student_group_id,
                $schedulePlan->plan_type_id,
                $schedulePlan->semester_id,
                $lesson->user_id,
                $lesson->subject_id,
                $duration->time_start,
                $duration->time_end,
                $schedule->description,
                $schedule->format_lesson_id,
            );
            $data[] = $card->toArray();
        }

        return $data;
    }
}
