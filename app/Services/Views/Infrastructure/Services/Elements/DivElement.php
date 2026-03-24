<?php
namespace App\Services\Views\Infrastructure\Services\Elements;

use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewNestedElement;
use App\Services\Views\Infrastructure\Services\Elements\AdditionalParams\ViewElementAdditionalParams;

class DivElement extends AbstractViewNestedElement
{
    private $text;

    public function __construct(ViewElementAdditionalParams $additionalParams, $text = '')
    {
        $this->additionalParams = $additionalParams;
        $this->text = $text;
    }

    public function getTemplate(): string
    {
        return 'div';
    }

    public function getPrefixTemplate(): string
    {
        return 'HTML';
    }

    public function getText(): string
    {
        return $this->text;
    }
}
