<?php

namespace App\Services\Validation\Infrastructure\Services\Factory;

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Validation\Domain\Services\ValidationJsBuilderInterface;
use App\Services\Validation\Infrastructure\Services\ValidationJsBuilder;

class ValidationJsBuilderFactory implements \App\Services\Validation\Domain\Services\Factory\ValidationJsBuilderFactoryInterface
{
    public function createJsBuilder(FormInterface $form): ValidationJsBuilderInterface
    {
        return new ValidationJsBuilder($form);
    }
}
