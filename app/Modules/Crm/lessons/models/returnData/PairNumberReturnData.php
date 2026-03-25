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

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'number' => $this->getNumber(),
        ];
    }
}
