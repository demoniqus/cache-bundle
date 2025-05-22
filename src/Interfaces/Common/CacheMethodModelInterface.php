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

namespace Demoniqus\CacheBundle\Interfaces\Common;

interface CacheMethodModelInterface
{
    public const CACHE_METHOD_UPDATE = 'update';
    public const CACHE_METHOD_GET = 'get';
    public const CACHE_METHOD_HAS = 'has';
    public const CACHE_METHOD_DELETE = 'delete';
}
