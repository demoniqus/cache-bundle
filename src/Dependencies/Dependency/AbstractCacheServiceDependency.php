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

namespace Demoniqus\CacheBundle\Dependencies\Dependency;

use Demoniqus\CacheBundle\Cache\CacheServiceInterface;
use Demoniqus\CacheBundle\Interfaces\Common\CacheServiceDependencyInterface;

abstract class AbstractCacheServiceDependency implements CacheServiceDependencyInterface
{
    private CacheServiceInterface $cacheService;
    private array $cache = [];
    /**
     * Cache depends on some entity but from another cache.
     */
    protected string $dependsOn;

    public function __construct(
        CacheServiceInterface $cacheService,
        string                $dependsOn
    ) {
        $this->cacheService = $cacheService;
        $this->dependsOn = $dependsOn;
    }

    public function getDependedEntities($entity, array $options = []): array
    {
        $hash = spl_object_hash($entity);
        $forceReload = $options[self::OPTION_FORCE_RELOAD] ?? false;

        return !$forceReload && isset($this->cache[$hash]) ?
            $this->cache[$hash] :
            ($this->cache[$hash] = $this->loadDependedEntities($entity, $options));
    }
    abstract protected function loadDependedEntities($entity, array $options): array;

    public function getDependsOnClass(): string
    {
        return $this->dependsOn;
    }

    public function getDependedCacheService(): CacheServiceInterface
    {
        return $this->cacheService;
    }
}
