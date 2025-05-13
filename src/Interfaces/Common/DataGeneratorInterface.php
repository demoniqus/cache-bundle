<?php
declare(strict_types=1);


namespace Demoniqus\CacheBundle\Interfaces\Common;

use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

interface DataGeneratorInterface
{
    public function generate(ParamsBagInterface $paramsBag);

}
