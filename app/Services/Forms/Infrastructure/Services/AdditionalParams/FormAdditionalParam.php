<?php
namespace App\Services\Forms\Infrastructure\Services\AdditionalParams;


class FormAdditionalParam implements \App\Services\Forms\Domain\Services\AdditionalParams\FormAdditionalParamInterface {
    private string $formId = '';
    private array $formClasses = [];
    private string $method = 'GET';
    private string $multiple = '';
    private string $url;

    public function __construct(string $method = 'GET', string $url = '', string $formId = '', array $formClasses = [])
    {
        $this->formId = $formId;
        $this->formClasses = $formClasses;
        $this->method = $method;
        $this->url = $url;
    }
    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getMultiple(): string
    {
        return $this->multiple;
    }

    public function setMultiple(string $multiple): void
    {
        $this->multiple = $multiple;
    }

    public function getElementId(): string
    {
        return $this->formId;
    }

    public function getElementClasses(): array
    {
        return $this->formClasses;
    }

    public function setElementId(string $elementId): void
    {
        $this->formId = $elementId;
    }

    public function setElementClasses(array $elementClasses): void
    {
        $this->formClasses = $elementClasses;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
