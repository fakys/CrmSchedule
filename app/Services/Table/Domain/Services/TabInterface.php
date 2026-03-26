<?php

namespace App\Services\Table\Domain\Services;

use App\Services\Views\Domain\Services\Elements\ViewElementInterface;

interface TabInterface extends ViewElementInterface
{
    public function getUrl(): string;

    public function elementContextId(): int;

    public function getText(): string;

    public function getIcon(): string;
}
