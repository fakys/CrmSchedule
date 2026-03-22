<?php

namespace App\Services\ProviderLoader\Infrastructure\Services;

use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\ProviderLoader\Domain\Services\ProviderLoaderInterface;
use App\Services\ProviderLoader\Infrastructure\Exceptions\ProviderServiceNotInstanceofAbstractException;
use App\Services\ProviderLoader\Infrastructure\Exceptions\ServiceNotFoundException;

class ProviderLoader implements ProviderLoaderInterface
{
    //массив с загруженными провайдерами
    protected $build_service_providers = [];

    /**
     * @var \App\Services\ProviderLoader\Domain\Services\ProviderInterface[] массив со всеми провайдерами
     */
    protected $service_providers = [];

    public function __construct(array $providers)
    {
        foreach ($providers as $service_provider) {
            if (in_array(ProviderInterface::class, class_implements($service_provider))) {
                $this->service_providers[$service_provider::serviceName()] = $service_provider;
            } else {
                throw new ProviderServiceNotInstanceofAbstractException();
            }
        }
    }

    public function loadService(string $service_name)
    {
        if (empty($this->service_providers[$service_name])) {
            throw new ServiceNotFoundException();
        }
        $service_provider = $this->service_providers[$service_name];
        foreach ($service_provider::dependsServices() as $dependsServiceName) {
            //Если есть зависимости, подгружаем их
            if (empty($this->build_service_providers[$dependsServiceName])) {
                $this->loadService($dependsServiceName);
            }
        }
        $this->build_service_providers[$service_provider::serviceName()] = $service_provider;
        app()->register($service_provider);
    }
}
