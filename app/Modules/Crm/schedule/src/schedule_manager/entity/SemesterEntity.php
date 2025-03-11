<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PairNumber;
use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;

/** Сущность для работы с номерами пар */
class PairNumberEntity
{
    /**
     * @var PairNumber[]
     */
    private $pairNumbers;

    /**
     * @param PairNumber[] $pairNumbers
     */
    public function __construct($pairNumbers)
    {
        if ($pairNumbers) {
            throw new ScheduleManagerException('Отсутствуют номера пар');
        }
        $this->pairNumbers = $pairNumbers;
    }

    public function getPairNumbers()
    {
        return $this->pairNumbers;
    }
}
