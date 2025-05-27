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

namespace Demoniqus\CacheBundle\Interfaces;

use Demoniqus\CacheBundle\Interfaces\Common\CacheServiceDependencyInterface;

interface DependedCacheServicesResolverInterface
{
    /**
     * @return CacheServiceDependencyInterface[]
     */
    public function resolve(string $entityClass): array;

    public function clear($entity, array $options = []);
}
