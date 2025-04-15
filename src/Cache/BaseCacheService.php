<?php
declare(strict_types=1);

namespace Demoniqus\CacheBundle\Cache;

use Demoniqus\CacheBundle\Interfaces\Common\CacheStorageInterface;
use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

abstract class BaseCacheService implements CacheServiceInterface
{
    /**
     * Хранилище данных
     */
    private CacheStorageInterface $cacheStorage;
    /**
     * Ключ cache состоит из нескольких частей:
     * - prefix - определяется параметрами подключения к хранилищу
     * - key - идентификатор конкретного сервиса App\Cache
     * - getCacheKey() - параметры на основе ParamsBag
     */
    private string $key;
    private string $cacheKeySplitter;

    public function __construct(
        string                $key,
        CacheStorageInterface $cacheStorage
    )
    {

        $this->cacheStorage = $cacheStorage;
        $this->key = $key;
        $this->cacheKeySplitter = ':';
    }

    public function update(?ParamsBagInterface $paramsBag): CacheServiceInterface
    {
        $this->cacheStorage->put(
            $this->generateCacheKey($paramsBag),
            $this->createData($paramsBag)

        );

        return $this;
    }

    public function get(?ParamsBagInterface $paramsBag)
    {
        return $this->cacheStorage->get($this->generateCacheKey($paramsBag));
    }

    public function has(?ParamsBagInterface $paramsBag): bool
    {
        return $this->cacheStorage->has($this->generateCacheKey($paramsBag));
    }

    public function clear(?ParamsBagInterface $paramsBag): CacheServiceInterface
    {
        $this->cacheStorage->put($this->generateCacheKey($paramsBag), null);

        return $this;
    }

    abstract protected function getCacheKey(?ParamsBagInterface $paramsBag): string;
    abstract protected function createData(?ParamsBagInterface $paramsBag);

    private function generateCacheKey(?ParamsBagInterface $paramsBag): string
    {
        return $this->key . $this->cacheKeySplitter . $this->getCacheKey($paramsBag);
    }
}
