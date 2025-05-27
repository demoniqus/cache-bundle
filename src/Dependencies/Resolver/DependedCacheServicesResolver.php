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

namespace Demoniqus\CacheBundle\Dependencies\Resolver;



use Demoniqus\CacheBundle\Interfaces\Common\CacheServiceDependencyInterface;
use Demoniqus\CacheBundle\Interfaces\DependedCacheServicesResolverInterface;
use Demoniqus\CacheBundle\ParamsBag\ParamsBag;

class DependedCacheServicesResolver implements DependedCacheServicesResolverInterface
{
    /**
     * @var CacheServiceDependencyInterface[][]
     */
    private array $dependencies = [];

    public function __construct(
        iterable $cacheServices
    ) {
        foreach ($cacheServices as $cacheService) {
            if (!$cacheService instanceof CacheServiceDependencyInterface) {
                throw new \RuntimeException('Cache service must implement CacheServiceDependencyInterface');
            }
            $this->dependencies[$cacheService->getDependsOnClass()][] = $cacheService;
        }
    }

    /**
     * @return CacheServiceDependencyInterface[]
     */
    public function resolve(string $entityClass): array
    {
        foreach ($this->dependencies as $className => $dependencies) {
            if (is_subclass_of($entityClass, $className)) {
                return $dependencies;
            }
        }

        return [];
    }

    public function clear($entity)
    {
        $dependencies = $this->resolve(get_class($entity));

        foreach ($dependencies as $dependency) {
            $paramsBag = new ParamsBag();
            $cacheService = $dependency->getDependedCacheService();

            foreach ($dependency->getDependedEntities($entity, false) as $dependedEntity) {

                $paramsBag->setParam($cacheService->getEntityParamName(), $dependedEntity);
                $cacheService->delete($paramsBag);
            }

        }

    }
}
