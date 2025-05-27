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

/**
 * Класс описывает зависимость кэша от сущности, но не от другого кэша.
 * В этом случае порядок расчета не имеет значения
 */
abstract class AbstractCacheServiceDependency implements CacheServiceDependencyInterface
{
    private CacheServiceInterface $cacheService;
    private array $cache = [];
    /**
     * Кэш зависит от сущности, а не от другого кэша
     */
    protected string $dependsOn;

    public function __construct(
        CacheServiceInterface $cacheService,
        string                $dependsOn
    ) {
        $this->cacheService = $cacheService;
        $this->dependsOn = $dependsOn;
    }

    public function getDependedEntities($entity, bool $forceReload = false): array
    {
        $hash = spl_object_hash($entity);
        return !$forceReload && isset($this->cache[$hash]) ?
            $this->cache[$hash] :
            ($this->cache[$hash] = $this->loadDependedEntities($entity));
    }
    abstract protected function loadDependedEntities($entity): array;

    public function getDependsOnClass(): string
    {
        return $this->dependsOn;
    }

    public function getDependedCacheService(): CacheServiceInterface
    {
        return $this->cacheService;
    }
}
