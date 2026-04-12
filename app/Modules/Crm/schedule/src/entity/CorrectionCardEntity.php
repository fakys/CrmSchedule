<?php

namespace App\Modules\Crm\schedule\src\entity;


class CorrectionCardEntity
{
    private $id;
    private $cardName;
    private $numberPair;
    private $teacherId;
    private $subjectId;
    private $timeStart;
    private $timeEnd;
    private $formatId;
    private $description;


    public function __construct(
        $id,
        $cardName,
        $numberPair,
        $teacherId = null,
        $subjectId = null,
        $timeStart = null,
        $timeEnd = null,
        $formatId = null,
        $description = null
    )
    {
        $this->id = $id;
        $this->cardName = $cardName;
        $this->numberPair = $numberPair;
        $this->teacherId = $teacherId;
        $this->subjectId = $subjectId;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->formatId = $formatId;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCardName()
    {
        return $this->cardName;
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

    public function getFormatId()
    {
        return $this->formatId;
    }

    public function getNumberPair()
    {
        return $this->numberPair;
    }
}
