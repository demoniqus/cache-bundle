<?php


declare(strict_types=1);

namespace Demoniqus\CacheBundle\Cache;

use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

interface CacheServiceInterface
{

    public function update(?ParamsBagInterface $paramsBag): CacheServiceInterface;

    /**
     * Get value from storage by key
     *
     * @return mixed
     */
    public function get(?ParamsBagInterface $paramsBag);

    /**
     * Здесь можно проверять, существует ли такой ключ как непосредственно в хранилище, так и в памяти данного сервиса
     */
    public function has(?ParamsBagInterface $paramsBag): bool;

    /**
     * Delete key from storage
     */
    public function clear(?ParamsBagInterface $paramsBag): CacheServiceInterface;

}
