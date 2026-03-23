<?php
namespace App\Services\Views\Infrastructure\Services\Elements;

use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewNestedElement;
use App\Services\Views\Infrastructure\Services\Elements\AdditionalParams\ViewElementAdditionalParams;

class DivElement extends AbstractViewNestedElement
{

    public function __construct(ViewElementAdditionalParams $additionalParams)
    {
        $this->additionalParams = $additionalParams;
    }

    public function getTemplate(): string
    {
        return 'div';
    }

    public function getPrefixTemplate(): string
    {
        return 'HTML';
    }
}
