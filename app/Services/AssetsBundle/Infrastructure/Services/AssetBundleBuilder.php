<?php

namespace App\Services\AssetsBundle\Infrastructure\Services;

use App\Services\AssetsBundle\Domain\Entity\AssetEntityFile;
use App\Services\AssetsBundle\Domain\Factory\CreateAssetFileEntityFactory;
use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\AssetDriverInterface;
use App\Services\AssetsBundle\Infrastructure\Exceptions\DriverTypePluginNotFoundException;
use App\Services\AssetsBundle\Infrastructure\Exceptions\TypeBundleException;
use App\Services\AssetsBundle\Infrastructure\Services\Collections\CollectionAssetBundle;

/**
 * Сборщик асетов
 */
class AssetBundleBuilder
{
    public function __construct(
        private CollectionAssetBundle $collection,
        private AssetDriverInterface $driver,
        private CreateAssetFileEntityFactory $factory
    ){}

    /**
     * Билдер файлов
     * @param \App\Services\AssetsBundle\Domain\Entity\AssetEntityFile $entity
     * @return mixed
     */
    public function buildFile(AssetEntityFile $entity)
    {
        return $this->driver->buildFile($entity);
    }

    /**
     * Билдер банделов
     * @throws \App\Services\AssetsBundle\Infrastructure\Exceptions\TypeBundleException
     * @throws \App\Services\AssetsBundle\Infrastructure\Exceptions\DriverTypePluginNotFoundException
     */
    public function buildAssetBundle(AssetBundleInterface $bundle)
    {
        if (!$this->collection->checkLoadBundle($bundle)) {
            $this->collection->loadBundle($bundle);

            foreach ($bundle->headerFiles() as $path) {
                $entity = $this->factory->createAssetFileEntity($path);
                $entity = $this->buildFile($entity);
                $this->collection->appendHeaderEntity($entity);
            }

            foreach ($bundle->bodyFiles() as $path) {
                $entity = $this->factory->createAssetFileEntity($path);
                $entity = $this->buildFile($entity);
                $this->collection->appendBodyEntity($entity);
            }

            foreach ($bundle->dependsBundle() as $bundleClass) {
                $bundle = new ($bundleClass)();
                if ($bundle instanceof AssetBundleInterface) {
                    $this->buildAssetBundle($bundle);
                    return;
                }
                throw new TypeBundleException('Неверный тип асета в зависимостях');
            }
        }
    }
}
