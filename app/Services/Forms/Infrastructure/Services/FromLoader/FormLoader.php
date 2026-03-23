<?php

namespace App\Services\Forms\Infrastructure\Services\FromLoader;


use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Forms\Domain\Services\FormLoader\FormLoaderInterface;
use App\Services\Forms\Infrastructure\Exceptions\DataFromFormLoaderInvalidFormatException;
use App\Services\Forms\Infrastructure\Exceptions\UndefinedEntityManagerException;

class FormLoader implements FormLoaderInterface
{
    public function __construct(
    ){}


    /**
     * @param \App\Services\Forms\Domain\Services\FormInterface $form
     * @param array $data
     * @return void
     */
    public function loadForm(FormInterface $form, $data)
    {
        if (is_array($data)) {
            $this->LoadFormArray($form, $data);
        } else {
            throw new DataFromFormLoaderInvalidFormatException();
        }
    }

    /**
     * ошибка
     * Загрузка формы через массив
     * @param $array - массив с данными для загрузчика
     * @return void
     */
    private function LoadFormArray(FormInterface $form, $array)
    {
        foreach ($array as $name => $value) {
            foreach ($form->getAllFields() as $element) {
                if ($element->getName() === $name) {
                    $element->setValue($value);
                }
            }
        }
    }
}
