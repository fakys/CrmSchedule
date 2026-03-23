<?php
namespace App\Services\Validation\Domain\Services;

interface RuleFormaterInterface {
    public function arrayFormater(array $rule);
    public function stringFormater(string $rule);
}
