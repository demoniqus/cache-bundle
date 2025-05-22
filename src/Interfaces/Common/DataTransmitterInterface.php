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

namespace Demoniqus\CacheBundle\Interfaces\Common;

interface DataTransmitterInterface
{
    public function put(
        CacheStorageInterface $cacheStorage,
        array $options,
        string $key,
        $data
    ): void;

    /**
     * @return mixed
     */
    public function get(
        CacheStorageInterface $cacheStorage,
        string $key
    );
}
