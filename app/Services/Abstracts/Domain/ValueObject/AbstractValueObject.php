<?php
namespace App\Services\Abstracts\Domain\ValueObject;

abstract class AbstractValueObject {
    protected $value;

    public function getValue()
    {
        return $this->value;
    }

    public function equals($value): bool
    {
        return $this->value === $value;
    }

    public function toString(): string
    {
        return (string)$this->value;
    }

    public function toInteger(): int
    {
        return (int)$this->value;
    }

    public function toFloat(): float
    {
        return (float)$this->value;
    }

    public function toBoolean(): bool
    {
        return (bool)$this->value;
    }
}
