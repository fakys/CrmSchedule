<?php
namespace App\Services\Forms\Infrastructure\Services\FormElement\Form;

use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewElement;

class FormHeaderElement extends AbstractViewElement
{
    const FORM_HEADER_TAG = 'header';
    private AbstractForm $form;
    public function __construct($form)
    {
        $this->form = $form;
        $this->tag = self::FORM_HEADER_TAG;
    }

    public function getTemplate(): string
    {
        return 'header_form';
    }

    public function getPrefixTemplate(): string
    {
        return AbstractForm::FORM_PREFIX;
    }

    public function getForm(): AbstractForm
    {
        return $this->form;
    }
}
