<?php
namespace App\Services\Validation\Domain\Services\Factory;

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Validation\Domain\Services\ValidationBuilderInterface;

interface ValidationBuilderFactoryInterface {
    public function createValidationBuilder(FormInterface $form): ValidationBuilderInterface;
}
