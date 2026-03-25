<?php
namespace App\Modules\Crm\lessons\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class AddSubjectReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('name')]
    private $name;

    #[ReturnDataFieldAttribute('full_name')]
    private $full_name;

    #[ReturnDataFieldAttribute('description')]
    private $description;

    public function getName(): string
    {
        return $this->name;
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'full_name' => $this->getFullName(),
            'description' => $this->getDescription(),
        ];
    }
}
