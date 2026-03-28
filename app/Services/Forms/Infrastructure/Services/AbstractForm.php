<?php

namespace App\Services\Forms\Infrastructure\Services;

use App\Services\Forms\Domain\Services\AdditionalParams\FormAdditionalParamInterface;
use App\Services\Forms\Domain\Services\FormElements\FormElementInterface;
use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Forms\Domain\Services\FormLoader\FormLoaderInterface;
use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataBuilderInterface;
use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;
use App\Services\Forms\Infrastructure\Services\FormElement\Form\FormEndElement;
use App\Services\Forms\Infrastructure\Services\FormElement\Form\FormHeaderElement;
use App\Services\Validation\Domain\Services\Factory\ValidationBuilderFactoryInterface;
use App\Services\Validation\Domain\Services\ValidationBuilderInterface;
use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewNestedElement;
use Illuminate\Support\HtmlString;

abstract class AbstractForm extends AbstractViewNestedElement implements FormInterface
{
    const FORM_PREFIX = 'default_form';
    private FormLoaderInterface $formLoader;

    private FromReturnDataInterface $formReturnData;
    private FromReturnDataBuilderInterface $formReturnBuilder;

    private ValidationBuilderInterface $validationBuilder;

    private array $allElements = [];

    protected FormHeaderElement $form_header;
    protected FormEndElement $form_end;

    public function __construct(string $formTag, FormAdditionalParamInterface $additionalParam)
    {
        /** Тут сделать загрузку контекста */
        $this->formLoader = app(FormLoaderInterface::class);
        $this->formReturnBuilder = app(FromReturnDataBuilderInterface::class);
        $this->formReturnData = new ($this->returnData())();

        $this->tag = $formTag;
        $this->additionalParams = $additionalParam;
        /** @var ValidationBuilderFactoryInterface $factory */
        $factory = app(ValidationBuilderFactoryInterface::class);
        $this->validationBuilder = $factory->createValidationBuilder($this);

        $this->form_header = new FormHeaderElement($this);
        $this->form_end = new FormEndElement($this);

        $this->buildForm();
    }

    public function load($data)
    {
        $this->formLoader->loadForm($this, $data);
        $this->formReturnBuilder->loadReturnData($this->formReturnData, $data);
    }

    public function getAdditionalParams(): FormAdditionalParamInterface
    {
        return $this->additionalParams;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getElementByTag(string $tag): AbstractFormElement
    {
        return $this->elements[$tag];
    }

    public function getTemplate(): string
    {
        return 'default_form';
    }

    public function getPrefixTemplate(): string
    {
        return self::FORM_PREFIX;
    }

    public function getValidationBuilder(): ValidationBuilderInterface
    {
        return $this->validationBuilder;
    }

    public function useValidateJs(): bool
    {
        return true;
    }

    /** Ошибка */
    public function toArray(): array
    {
        $data = [];
        foreach ($this->getAllFields() as $element) {
            $data[$element->getName()] = $element->getValue();
        }
        return $data;
    }

    public function getAllFields(): array
    {
        $data = $this->allElements;
        if (!$data) {
            $this->checkElement($this->getElements(), $data);
        }
        $this->allElements = $data;
        return $data;
    }

    private function checkElement($elements, &$data)
    {

        foreach ($elements as $element) {
            if ($element instanceof FormElementInterface) {
                $data[$element->getName()] = $element;
                //Если у элемента есть вложенные элементы, то мы среди них ищем FormElementInterface
            } elseif ($element instanceof ViewNestedElementInterface) {
                $this->checkElement($element->getElements(), $data);
            }
        }
    }

    public function getReturnData(): FromReturnDataInterface
    {
        return $this->formReturnData;
    }

    public function startForm(): ViewElementInterface
    {
        return $this->form_header;
    }

    public function endForm(): ViewElementInterface
    {
        return $this->form_end;
    }

    public function isAjax()
    {
        return false;
    }
}
