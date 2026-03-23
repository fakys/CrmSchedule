<?php

namespace App\Services\Forms\Domain\Services\AdditionalParams;

interface FormAdditionalParamInterface extends \App\Services\Views\Domain\Services\AdditionalParams\ViewElementAdditionalParamsInterface
{
    public function getMethod(): string;

    public function setMethod(string $method): void;

    public function getMultiple(): string;

    public function setMultiple(string $multiple): void;
    public function getUrl(): string;
    public function setUrl(string $url): void;
}
