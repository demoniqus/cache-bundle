<?php


declare(strict_types=1);

namespace Demoniqus\CacheBundle\Interfaces\Common;
interface CacheStorageInterface extends CacheInterface
{
    public function eval(string $script, array $args = [], int $num_keys = 0);

    public function hMSet(string $key, array $values, ?array $options): CacheStorageInterface;
    public function hSet(string $key, string $member, $value): CacheStorageInterface;

    public function beginTransaction(): CacheStorageInterface;
    public function expire(string $key, int $timeout, ?string $mode = null): CacheStorageInterface;

}
