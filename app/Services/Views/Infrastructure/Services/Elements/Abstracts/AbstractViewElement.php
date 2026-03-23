<?php

namespace App\Services\Views\Infrastructure\Services\Elements\Abstracts;

use App\Services\Views\Domain\Services\AdditionalParams\ViewElementAdditionalParamsInterface;
use App\Services\Views\Domain\Services\Elements\ViewElementInterface;

abstract class AbstractViewElement implements ViewElementInterface
{
    protected $group = '';

    protected $tag = '';

    protected $access;

    protected ?ViewElementAdditionalParamsInterface $additionalParams;

    public function getAssets(): array
    {
        return [];
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getAdditionalParams(): ?ViewElementAdditionalParamsInterface
    {
        return $this->additionalParams;
    }

    public function setAdditionalParams(ViewElementAdditionalParamsInterface $params)
    {
        $this->additionalParams = $params;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function setGroup(string $group): void
    {
        $this->group = $group;
    }
    public function getAccess(): string
    {
        return $this->access;
    }

    public function setAccess(string $cid): void
    {
        $this->access = $cid;
    }
}
