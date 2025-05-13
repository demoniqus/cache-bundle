<?php
declare(strict_types=1);

namespace Demoniqus\CacheBundle\Interfaces\Common;

use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

interface CacheKeyGeneratorInterface
{
    public function generate(string $serviceKey, ParamsBagInterface $paramsBag);

}
