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

interface CacheStorageInterface extends CacheInterface
{
    public function eval(string $script, array $args = [], int $num_keys = 0);

    public function hMSet(string $key, array $values, ?array $options): CacheStorageInterface;

    public function hSet(string $key, string $member, $value): CacheStorageInterface;

    public function beginTransaction(): CacheStorageInterface;

    public function expire(string $key, int $timeout, string $mode = null): CacheStorageInterface;
}
