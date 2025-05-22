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

namespace Demoniqus\CacheBundle\ParamsBag;

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

    public function hasParam($paramName): bool
    {
        return \array_key_exists($paramName, $this->params);
    }
}
