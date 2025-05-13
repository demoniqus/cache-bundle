<?php

namespace Demoniqus\CacheBundle\Interfaces\Common;

interface CacheInterface
{
    /**
     * Put value to storage with key using some options
     *
     * @param $key
     * @param $value
     * @param array|null $options
     * @return CacheInterface
     */
    public function put(string $key, $value, ?array $options = []): CacheInterface;

    /**
     * Get value from storage by key
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    public function beginTransaction(): CacheInterface;

    public function commit(): void;

    /**
     * Здесь можно проверять, существует ли такой ключ как непосредственно в хранилище, так и в памяти данного сервиса
     */
    public function has(string $key): bool;

    /**
     * Delete key from storage
     *
     * @param string $key
     * @return CacheInterface
     */
    public function delete(string $key): CacheInterface;

    public function hMSet(string $key, array $values, ?array $options): CacheInterface;
    public function hSet(string $key, string $member, $value): CacheInterface;

    public function hGet(string $key, string $member);
    public function hGetAll(string $key);

    public function expire(string $key, int $timeout, ?string $mode = null):CacheInterface;
}
