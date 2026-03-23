<?php
namespace App\Services\Validation\Infrastructure\Services;

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Validation\Domain\Services\ValidationBuilderInterface;
use App\Services\Validation\Domain\Services\ValidationJsBuilderInterface;
use Illuminate\Contracts\Validation\Factory;

/**
 * Билдер правил валидации
 */
class ValidationBuilder implements ValidationBuilderInterface
{
    private $rules = [];

    public function __construct(
        private Factory $validatorFactory,
        private ValidationJsBuilderInterface $validationJsBuilder,
        private FormInterface $form,
    ){}

    public function getSetRules(array $rules)
    {
        $this->rules = $rules;
        //Заполняет элементы js валидацией
        if ($this->form->useValidateJs()) {
            $this->validationJsBuilder->setJsRules($rules);
        }
    }
    public function validate(): array
    {
        return $this->validatorFactory->make($this->form->toArray(), $this->rules, [], $this->form->getAttribute())->validate();
    }
}
