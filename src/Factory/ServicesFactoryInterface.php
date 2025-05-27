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

interface ServicesFactoryInterface
{
    public function getService(string $serviceAlias): CacheServiceInterface;

    public function getServiceKey(CacheServiceInterface $instance): string;
}
