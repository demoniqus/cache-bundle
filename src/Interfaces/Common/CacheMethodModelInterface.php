<?php
declare(strict_types=1);


namespace Demoniqus\CacheBundle\Interfaces\Common;

interface CacheMethodModelInterface
{
    public const CACHE_METHOD_UPDATE = 'update';
    public const CACHE_METHOD_GET = 'get';
    public const CACHE_METHOD_HAS = 'has';
    public const CACHE_METHOD_DELETE = 'delete';
}
