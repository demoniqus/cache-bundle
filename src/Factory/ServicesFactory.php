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
    private array $services = [];

    public function registerService(string $serviceAlias, CacheServiceInterface $service): void
    {
        $this->services[$serviceAlias] = $service;
    }

    public function getService(string $serviceAlias): CacheServiceInterface
    {
        if (!isset($this->services[$serviceAlias])) {
            throw new ServiceNotFoundException('Service "'.$serviceAlias.'" not found');
        }

        return $this->services[$serviceAlias];
    }
}
