<?php


declare(strict_types=1);

namespace Demoniqus\CacheBundle\Interfaces\Common;
interface CacheServiceInterface
{
    /**
     * Put value to storage with key using some options
     *
     * @param $key
     * @param $value
     * @param array|null $options
     * @return CacheServiceInterface
     */
    public function put($key, $value, ?array $options = []): CacheServiceInterface;

    /**
     * Get value from storage by key
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * Здесь можно проверять, существует ли такой ключ как непосредственно в хранилище, так и в памяти данного сервиса
     */
    public function has(string $key): bool;

    /**
     * Configure service
     *
     * @param CacheServiceConfigInterface $config
     * @return CacheServiceInterface
     */
    public function configure(CacheServiceConfigInterface $config): CacheServiceInterface;


    /**
     * Delete key from storage
     *
     * @param string $key
     * @return CacheServiceInterface
     */
    public function delete(string $key): CacheServiceInterface;

    /**
     * Terminate service after using
     *
     * @return void
     */
    public function destruct(): void;

}
