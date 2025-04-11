<?php

declare(strict_types=1);
namespace Demoniqus\CacheBundle;

use Demoniqus\CacheBundle\DependencyInjection\Compiler\CacheCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CacheBundle extends Bundle
{
    public const CACHE_BUNDLE = 'cache';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new CacheCompiler());
    }

}
