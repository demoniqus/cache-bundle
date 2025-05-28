<?php

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

interface CacheInterface
{
    /**
     * Put value to storage with key using some options.
     */
    public function put(string $key, $value, ?array $options = []): CacheInterface;

    /**
     * Get value from storage by key.
     *
     * @return mixed
     */
    public function get(string $key);

    public function beginTransaction(): CacheInterface;

    public function commit(): void;

    public function has(string $key): bool;

    /**
     * Delete key from storage.
     */
    public function delete(string $key): CacheInterface;

    public function hMSet(string $key, array $values, ?array $options): CacheInterface;

    public function hSet(string $key, string $member, $value): CacheInterface;

    public function hGet(string $key, string $member);

    public function hGetAll(string $key);

    public function expire(string $key, int $timeout, string $mode = null): CacheInterface;
}
