<?php

declare(strict_types=1);

/*
 * This file is part of the package ITE product.
 *
 * Developer list:
 * (c) Dmitry Antipov <demoniqus@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Demoniqus\CacheBundle\DataTransmitter;

use Demoniqus\CacheBundle\Interfaces\Common\CacheStorageInterface;
use Demoniqus\CacheBundle\Interfaces\Common\DataTransmitterInterface;

final class StringedDataTransmitter implements DataTransmitterInterface
{
    public function put(CacheStorageInterface $cacheStorage, array $options, string $key, $data): void
    {
        $cacheStorage->put(
            $key,
            $data,
            $options
        );
    }

    public function get(CacheStorageInterface $cacheStorage, string $key)
    {
        return $cacheStorage->get($key);
    }
}
