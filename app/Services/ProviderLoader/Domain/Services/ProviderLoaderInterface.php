<?php

namespace App\Services\ProviderLoader\Domain\Services;

interface ProviderLoaderInterface
{
    public function loadService(string $service_name);
}
