<?php
namespace App\Modules\Crm\lessons\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class PairNumberReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('name')]
    private $name;

    #[ReturnDataFieldAttribute('number')]
    private $number;

    #[ReturnDataFieldAttribute('time_start')]
    private $time_start;

    #[ReturnDataFieldAttribute('time_end')]
    private $time_end;

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getTimeStart(): string
    {
        return $this->time_start;
    }

    public function getTimeEnd(): string
    {
        return $this->time_end;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'number' => $this->getNumber(),
            'time_start' => $this->getTimeStart(),
            'time_end' => $this->getTimeEnd(),
        ];
    }
}
