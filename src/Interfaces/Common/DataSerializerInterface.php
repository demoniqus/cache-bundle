<?php
declare(strict_types=1);


namespace Demoniqus\CacheBundle\Interfaces\Common;

interface DataSerializerInterface
{
    public function serialize($data): string;

    public function unserialize(string $data);

}
