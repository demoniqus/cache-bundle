<?php
declare(strict_types=1);

namespace Demoniqus\CacheBundle\ParamsBag;

use AppBundle\Interfaces\ParamsBagInterface;

class ParamsBag implements ParamsBagInterface
{
    private array $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function setParam(string $key, $value): ParamsBagInterface
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function getParam($paramName)
    {
        return $this->params[$paramName] ?? null;
    }
}
