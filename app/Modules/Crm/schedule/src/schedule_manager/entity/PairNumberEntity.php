<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PairNumber;
use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;

/** Сущность для работы с номерами пар */
class PairNumberEntity
{
    /**
     * @var array
     */
    private $pairNumbers;

    /**
     * @param PairNumber[] $pairNumbers
     */
    public function __construct($pairNumbers)
    {
        if (!$pairNumbers) {
            throw new ScheduleManagerException('Отсутствуют номера пар');
        }
        foreach ($pairNumbers as $pairNumber) {
            $this->pairNumbers[] = ['id' => $pairNumber->id,'number' => $pairNumber->number, 'name'=>$pairNumber->name];
        }

    }

    public function getPairNumbers()
    {
        return $this->pairNumbers;
    }

    public function getPairByNumber($number)
    {
        foreach ($this->pairNumbers as $pairNumber) {
            if ($pairNumber['number'] == $number) {
                return $pairNumber;
            }
        }
    }
}
