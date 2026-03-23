<?php

namespace App\Services\Validation\Infrastructure\Services\Factory;

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Validation\Domain\Services\ValidationBuilderInterface;
use App\Services\Validation\Infrastructure\Services\ValidationBuilder;
use Illuminate\Contracts\Validation\Factory;

class ValidationBuilderFactory implements \App\Services\Validation\Domain\Services\Factory\ValidationBuilderFactoryInterface
{
    public function __construct(
        private Factory                                                                              $factory,
        private \App\Services\Validation\Domain\Services\Factory\ValidationJsBuilderFactoryInterface $validationJsBuilderFactory,
    ){}

    public function createValidationBuilder(FormInterface $form): ValidationBuilderInterface
    {
        $js_builder = $this->validationJsBuilderFactory->createJsBuilder($form);
        return new ValidationBuilder($this->factory, $js_builder, $form);
    }
}
