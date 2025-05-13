<?php
declare(strict_types=1);


namespace Demoniqus\CacheBundle\Interfaces\Common;

use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

interface CacheParamsValidatorInterface
{
    public function validate(ParamsBagInterface $paramsBag, string $action): void;

}
