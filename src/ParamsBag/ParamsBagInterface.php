<?php
declare(strict_types=1);

namespace Demoniqus\CacheBundle\ParamsBag;

interface ParamsBagInterface
{

    public function setParam(string $key, $value): ParamsBagInterface;

    public function getParam($paramName);
    public function hasParam($paramName): bool;

}
