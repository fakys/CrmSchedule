<?php
namespace App\Services\Table\Infrastructure\Services;

use App\Services\Table\Domain\Services\TabInterface;
use App\Services\Table\Domain\Services\TableInterface;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewNestedElement;

abstract class AbstractTable extends AbstractViewNestedElement implements TableInterface
{
    const BASE_TABLE_PREFIX = 'base_table_prefix';

    protected $data = [];

    protected $url_tabs = '';

    public function __construct($tag, $data, $url_tabs = '')
    {
        $this->tag = $tag;
        $this->data = $data;
        $this->url_tabs = $url_tabs;
        $this->buildTable();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getUrlTabs(): string
    {
        return $this->url_tabs;
    }

    public function getTemplate(): string
    {
        return 'base_table';
    }

    public function getPrefixTemplate(): string
    {
        return self::BASE_TABLE_PREFIX;
    }

    public function appendTab($text, $icon, $url, $color, $access = '')
    {
        $this->appendElements(new TabElement($text, $icon, $url, $color, $access));
    }

    abstract public function buildTable();
    abstract public function getColumns(): array;
}
