<?php
declare(strict_types=1);

namespace Demoniqus\CacheBundle\Factory;


use Demoniqus\CacheBundle\Interfaces\Common\CacheServiceInterface;

interface ServicesFactoryInterface
{
    public function getService(string $serviceAlias): CacheServiceInterface;

}
