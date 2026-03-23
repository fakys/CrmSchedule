<?php
namespace App\Services\Validation\Infrastructure\Services;

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Validation\Domain\Services\RuleFormaterInterface;
use App\Services\Validation\Domain\Services\ValidationJsBuilderInterface;
use App\Services\Validation\Infrastructure\Services\Exceptions\InvalidValidateFormatException;

/**
 * Билдер правил валидации на стороне js
 */
class ValidationJsBuilder implements ValidationJsBuilderInterface
{
    const PREFIX = 'JsValidation';
    const ELEMENT_GROUP_NAME = 'validation';

    private FormInterface $form;

    public function __construct(
        FormInterface $form
    ){
        $this->form = $form;
    }

    /**
     * @return \App\Services\Validation\Domain\Services\RuleFormaterInterface
     */
    protected function getFormater()
    {
        return app(RuleFormaterInterface::class);
    }


    public function setJsRules(array $rules)
    {
        foreach ($rules as $field => $rule) {
            if (is_array($rule)) {
                $data = $this->getFormater()->arrayFormater($rule);
            } elseif (is_string($rule)) {
                $data = $this->getFormater()->stringFormater($rule);
            } else {
                throw new InvalidValidateFormatException();
            }
            foreach ($data as $value) {
                if (app()->has(self::PREFIX.'.'.$value['name'])) {
                    /** @var \App\Services\Validation\Domain\Services\ValidationJsRules\ValidationJsRulesInterface $ruleEntity */
                    $ruleEntity = app(self::PREFIX.'.'.$value['name']);
                    $ruleEntity->setFieldName($field);
                    $ruleEntity->setRule($value['rule']);
                    $ruleEntity->setGroup(self::ELEMENT_GROUP_NAME);
                    //Если сущность с js валидацией была найдена в ядре, закидываем её в элемент формы
                    if (isset($this->form->getAllFields()[$field])) {
                        /** @var \App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement $element */
                        $element = $this->form->getAllFields()[$field];
                        $element->appendElements($ruleEntity);
                        $ruleEntity->setType($element->getTypeValue());
                        if (isset($this->form->getAttribute()[$field])) {
                            $ruleEntity->setFieldRuName($this->form->getAttribute()[$field]);
                        }
                    }
                }
            }
        }
    }
}
