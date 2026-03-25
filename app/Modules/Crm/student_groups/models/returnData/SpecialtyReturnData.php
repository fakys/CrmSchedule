<?php
namespace App\Modules\Crm\student_groups\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class SpecialtyReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('name')]
    private $name;

    #[ReturnDataFieldAttribute('number')]
    private $number;

    #[ReturnDataFieldAttribute('description')]
    private $description;

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'number' => $this->getNumber(),
            'description' => $this->getDescription(),
        ];
    }
}
