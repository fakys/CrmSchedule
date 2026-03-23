<?php
namespace App\Services\Validation\Domain\Services\Factory;

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Validation\Domain\Services\ValidationJsBuilderInterface;

interface ValidationJsBuilderFactoryInterface {
    public function createJsBuilder(FormInterface $form): ValidationJsBuilderInterface;
}
