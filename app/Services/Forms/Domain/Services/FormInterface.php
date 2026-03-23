<?php

namespace App\Services\Forms\Domain\Services;


use App\Services\Forms\Domain\Services\AdditionalParams\FormAdditionalParamInterface;
use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Validation\Domain\Services\ValidationBuilderInterface;
use App\Services\Views\Domain\Services\Elements\ViewElementInterface;

interface FormInterface extends ViewElementInterface
{
    public function load($data);
    public function getAdditionalParams(): FormAdditionalParamInterface;
    public function setAdditionalParams(FormAdditionalParamInterface $params);
    public function getValidationBuilder():ValidationBuilderInterface;
    public function getAttribute(): array;
    public function useValidateJs(): bool;

    /**
     * Сюда передаем объект ReturnData для формы
     * @return string
     */
    public function returnData(): string;
    public function getReturnData(): FromReturnDataInterface;
    public function toArray(): array;

    /**
     * Возвращает все элементы формы
     * @return \App\Services\Forms\Domain\Services\FormElements\FormElementInterface[]
     */
    public function getAllFields(): array;
    public function buildForm();
}
