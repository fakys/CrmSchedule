<?php
namespace App\Modules\Crm\users_interface\model\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class UsersGroupReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('name')]
    private $name;

    #[ReturnDataFieldAttribute('description')]
    private $description = '';

    #[ReturnDataFieldAttribute('accesses')]
    private $accesses = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAccesses(): ?array
    {
        return $this->accesses;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'accesses' => $this->getAccesses(),
        ];
    }
}
