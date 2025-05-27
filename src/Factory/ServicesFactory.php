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

namespace Demoniqus\CacheBundle\Factory;

use Demoniqus\CacheBundle\Cache\CacheServiceInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ServicesFactory implements ServicesFactoryInterface
{
    private const BY_ALIAS = 1;
    private const BY_INSTANCE = 2;
    private array $services = [
        self::BY_ALIAS => [],
        self::BY_INSTANCE => [],
    ];

    public function registerService(string $serviceAlias, CacheServiceInterface $service): void
    {
        $this->services[self::BY_ALIAS][$serviceAlias] = $service;
        $this->services[self::BY_INSTANCE][spl_object_hash($service)] = $serviceAlias;

    }

    public function getService(string $serviceAlias): CacheServiceInterface
    {
        if (!isset($this->services[self::BY_ALIAS][$serviceAlias])) {
            throw new ServiceNotFoundException('Service "'.$serviceAlias.'" not found');
        }

        return $this->services[self::BY_ALIAS][$serviceAlias];
    }
    public function getServiceKey(CacheServiceInterface $instance): string
    {
        $hash = spl_object_hash($instance);
        if (!isset($this->services[self::BY_INSTANCE][$hash])) {
            throw new ServiceNotFoundException('Service "'.$hash.'" not found');
        }

        return $this->services[self::BY_INSTANCE][$hash];
    }
}
