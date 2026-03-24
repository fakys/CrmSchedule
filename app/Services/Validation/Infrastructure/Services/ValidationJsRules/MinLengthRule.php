<?php
namespace App\Services\Validation\Infrastructure\Services\ValidationJsRules;

use App\Services\Validation\Infrastructure\Services\ValidationJsRules\Abstracts\AbstractRule;

class MinLengthRule extends AbstractRule
{
    private $min;

    public function getMessage(): string
    {
        $message = $this->getValidateRuMessages()[$this->ruleName()][$this->getType()];

        $str_attr = str_replace(':attribute', $this->getFieldRuName(), $message);
        $str_min = str_replace(':min', $this->min, $str_attr);

        return $str_min;
    }

    public function setRule(string $rule){
        $this->min = explode(':', $rule)[1];
        /** @var \App\Services\Validation\Domain\Services\ValidationJsRules\ValidationRulesAdditionalParamsInterface $params */
        $params = $this->getAdditionalParams();
        $params->setAttributes(['min' => $this->min]);
    }

    public static function ruleName(): string
    {
        return 'min';
    }
}
