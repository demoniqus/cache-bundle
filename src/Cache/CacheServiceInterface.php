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

namespace Demoniqus\CacheBundle\Cache;

use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

interface CacheServiceInterface
{
    /**
     * @return mixed|false - return false in case cannot update cache
     */
    public function update(ParamsBagInterface $paramsBag);

    /**
     * Get value from storage by key.
     *
     * @return mixed
     */
    public function get(ParamsBagInterface $paramsBag);

    /**
     * Здесь можно проверять, существует ли такой ключ как непосредственно в хранилище, так и в памяти данного сервиса.
     */
    public function has(ParamsBagInterface $paramsBag): bool;

    /**
     * Delete key from storage.
     */
    public function delete(ParamsBagInterface $paramsBag): bool;

    public function generateCacheKey(ParamsBagInterface $paramsBag): string;

    public function getEntityParamName(): string;
}
