<?php
namespace App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ReturnDataFieldAttribute
{
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
