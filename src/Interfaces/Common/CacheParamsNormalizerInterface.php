<?php
declare(strict_types=1);


namespace Demoniqus\CacheBundle\Interfaces\Common;

use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

interface CacheParamsNormalizerInterface
{
    public function normalize(ParamsBagInterface $paramsBag, string $action): void;

}
