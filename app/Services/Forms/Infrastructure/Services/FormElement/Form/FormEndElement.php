<?php
namespace App\Services\Forms\Infrastructure\Services\FormElement\Form;

use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewElement;

/** Тут мы стили не прописываем */
class FormEndElement extends AbstractViewElement
{
    const FORM_END_TAG = 'end';

    public function __construct()
    {
        $this->tag = self::FORM_END_TAG;
    }

    public function getTemplate(): string
    {
        return 'end_form';
    }

    public function getPrefixTemplate(): string
    {
        return AbstractForm::FORM_PREFIX;
    }
}
