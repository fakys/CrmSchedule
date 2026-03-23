<?php
namespace App\Services\Validation\Domain\Services;

interface ValidationBuilderInterface {
    public function getSetRules(array $rules);
    public function validate(): array;
}
