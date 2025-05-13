<?php
declare(strict_types=1);


namespace Demoniqus\CacheBundle\Interfaces\Common;

use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

interface OptionsResolverInterface
{

    public function resolve(ParamsBagInterface $paramsBag, string $action, array &$options): void;
}
