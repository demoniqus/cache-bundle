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

namespace Demoniqus\CacheBundle\DependencyInjection\Compiler;

use Demoniqus\CacheBundle\Factory\ServicesFactory;
use Demoniqus\CacheBundle\Interfaces\BundleConstantsModelInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CacheCompiler implements CompilerPassInterface
{
    private ?ContainerBuilder $container = null;

    public function process(ContainerBuilder $container)
    {
        $this
            ->setContainer($container)
            ->addServices()
        ;
    }

    public function setContainer($container): self
    {
        $this->container = $container;

        return $this;
    }

    private function addServices(): self
    {
        $definition = $this->container->findDefinition(ServicesFactory::class);
        $cacheServices = $this->container->findTaggedServiceIds(BundleConstantsModelInterface::CACHE_SERVICE_TAG);

        foreach ($cacheServices as $serviceId => $tags) {
            $definition->addMethodCall(
                'registerService',
                [
                    $tags[0]['alias'] ?? $tags['alias'] ?? $serviceId,
                    new Reference($serviceId),
                ]
            );
        }

        return $this;
    }
}
