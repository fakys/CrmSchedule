<?php
namespace App\Modules\Crm\student_groups\src;

class MassAddStudentsGroupEntity
{
    private $number;
    private $name;

    public function __construct(string $number, ?string $name)
    {
        $this->number = $number;
        $this->name = $name;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
