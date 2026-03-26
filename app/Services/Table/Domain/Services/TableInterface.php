<?php

namespace App\Services\Table\Domain\Services;

use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;

interface TableInterface extends ViewNestedElementInterface
{
    public function getColumns(): array;
    public function getData(): array;
    public function appendTab($text, $icon, $url, $color, $access = '');
}
