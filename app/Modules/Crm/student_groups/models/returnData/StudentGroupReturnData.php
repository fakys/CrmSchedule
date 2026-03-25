<?php
namespace App\Modules\Crm\student_groups\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class StudentGroupReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('name')]
    private $name;

    #[ReturnDataFieldAttribute('number')]
    private $number;

    #[ReturnDataFieldAttribute('specialty')]
    private $specialty;

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getSpecialty(): ?string
    {
        return $this->specialty;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'number' => $this->getNumber(),
            'specialty' => $this->getSpecialty(),
        ];
    }
}
