<?php
declare(strict_types=1);

namespace Demoniqus\CacheBundle\DataTransmitter;

use Demoniqus\CacheBundle\Interfaces\Common\CacheStorageInterface;
use Demoniqus\CacheBundle\Interfaces\Common\DataTransmitterInterface;

final class HashedDataTransmitter implements DataTransmitterInterface
{

    public function put(CacheStorageInterface $cacheStorage, array $options, string $key, $data): void
    {
        $cacheStorage->hMSet(
            $key,
            $data,
            $options
        );
    }

    public function get(CacheStorageInterface $cacheStorage, string $key)
    {
        return $cacheStorage->hGetAll($key);
    }
}
