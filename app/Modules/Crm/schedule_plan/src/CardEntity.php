<?php

namespace App\Modules\Crm\schedule_plan\src;


class CardEntity
{
    private $cardId;
    private $cardName;
    private $numberPair;
    private $weekDay;
    private $weekNumber;
    private $groupId;
    private $teacherId;
    private $subjectId;
    private $timeStart;
    private $timeEnd;
    private $description;
    private $planTypeId;
    private $formatId;
    private $semesterId;
    private $errorMessage;


    public function __construct(
        $cardId,
        $cardName,
        $numberPair,
        $weekDay,
        $weekNumber,
        $groupId,
        $planTypeId,
        $semesterId = null,
        $teacherId = null,
        $subjectId = null,
        $timeStart = null,
        $timeEnd = null,
        $description = null,
        $formatId = null,
        $errorMessage = null,
    )
    {
        $this->cardId = $cardId;
        $this->cardName = $cardName;
        $this->numberPair = $numberPair;
        $this->weekDay = $weekDay;
        $this->weekNumber = $weekNumber;
        $this->groupId = $groupId;
        $this->teacherId = $teacherId;
        $this->subjectId = $subjectId;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->description = $description;
        $this->planTypeId = $planTypeId;
        $this->formatId = $formatId;
        $this->semesterId = $semesterId;
        $this->errorMessage = $errorMessage;
    }

    public function getCardId()
    {
        return $this->cardId;
    }

    public function getCardName()
    {
        return $this->cardName;
    }

    public function getNumberPair()
    {
        return $this->numberPair;
    }

    public function getWeekDay()
    {
        return $this->weekDay;
    }

    public function getWeekNumber()
    {
        return $this->weekNumber;
    }

    public function getGroupId()
    {
        return $this->groupId;
    }

    public function getTeacherId()
    {
        return $this->teacherId;
    }

    public function getSubjectId()
    {
        return $this->subjectId;
    }

    public function getTimeStart()
    {
        return $this->timeStart;
    }

    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPlanTypeId()
    {
        return $this->planTypeId;
    }

    public function getFormatId()
    {
        return $this->formatId;
    }

    public function getSemesterId()
    {
        return $this->semesterId;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function toArray()
    {
        return [
            'cardId' => $this->cardId,
            'cardName' => $this->cardName,
            'numberPair' => $this->numberPair,
            'weekDay' => $this->weekDay,
            'weekNumber' => $this->weekNumber,
            'groupId' => $this->groupId,
            'teacherId' => $this->teacherId,
            'planTypeId' => $this->planTypeId,
            'semesterId' => $this->semesterId,
            'subjectId' => $this->subjectId,
            'timeStart' => $this->timeStart,
            'timeEnd' => $this->timeEnd,
            'formatId' => $this->formatId,
            'description' => $this->description,
            'errorMessage' => $this->errorMessage,
        ];
    }
}
