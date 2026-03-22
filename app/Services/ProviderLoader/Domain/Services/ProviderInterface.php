<?php
namespace App\Services\ProviderLoader\Domain\Services;

interface ProviderInterface {
    public static function serviceName(): string;

    /**
     * Зависимые сервисы
     * @return string[]
     */
    public static function dependsServices(): array;
}
