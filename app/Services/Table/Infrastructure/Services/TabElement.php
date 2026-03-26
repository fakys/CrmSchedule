<?php
namespace App\Services\Table\Infrastructure\Services;

use App\Services\Table\Domain\Services\TabInterface;
use App\Services\Table\Domain\Services\TableInterface;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewNestedElement;

class TabElement extends AbstractViewNestedElement implements TabInterface
{
    const TAB_GROUP = 'tab';

    protected $text;

    protected $icon;

    protected $url;

    protected $color;
    protected $context_id;

    public function __construct($text, $icon, $url, $color, $context_id, $access = '')
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->url = $url;
        $this->color = $color;
        $this->access = $access;
        $this->context_id = $context_id;
        $this->group = self::TAB_GROUP;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function elementContextId(): int
    {
        return $this->context_id;
    }

    public function getTemplate(): string
    {
        return 'tab';
    }

    public function getPrefixTemplate(): string
    {
        return '';
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}
