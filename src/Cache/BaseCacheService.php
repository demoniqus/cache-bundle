<?php
declare(strict_types=1);

namespace Demoniqus\CacheBundle\Cache;

use Demoniqus\CacheBundle\Interfaces\Common\CacheKeyGeneratorInterface;
use Demoniqus\CacheBundle\Interfaces\Common\CacheMethodModelInterface;
use Demoniqus\CacheBundle\Interfaces\Common\CacheParamsNormalizerInterface;
use Demoniqus\CacheBundle\Interfaces\Common\CacheParamsValidatorInterface;
use Demoniqus\CacheBundle\Interfaces\Common\CacheStorageInterface;
use Demoniqus\CacheBundle\Interfaces\Common\DataGeneratorInterface;
use Demoniqus\CacheBundle\Interfaces\Common\DataSerializerInterface;
use Demoniqus\CacheBundle\Interfaces\Common\DataTransmitterInterface;
use Demoniqus\CacheBundle\Interfaces\Common\OptionsResolverInterface;
use Demoniqus\CacheBundle\ParamsBag\ParamsBagInterface;

abstract class BaseCacheService implements CacheServiceInterface
{
    //TODO надо продумать время жизни cache:
    // - справочники живут постоянно, обычно меняются нечасто или вообще могут после создания почти не меняться
    // - те же закрытые доходные договоры могут вообще существовать вечно
    // - некоторые данные меняются весьма часто ми для них можно устанавливать короткий срок жизни cache
    // Но во многих случаях срок жизни необходим, т.к. исходные данные могут быть просто удалены, а
    // cache станет неактуальным, никто не будет за ним обращаться - он будет тупо занимать место.
    // \Redis::pexpire()
    /**
     * Хранилище данных
     */
    private CacheStorageInterface $cacheStorage;
    /**
     * Ключ cache состоит из нескольких частей:
     * - prefix - определяется параметрами подключения к хранилищу
     * - key - идентификатор конкретного сервиса App\Cache
     * - getCacheKey() - параметры на основе ParamsBag
     */
    private string $key;

    /**
     * @var CacheParamsValidatorInterface[]
     */
    private array $validators = [];
    /**
     * @var CacheParamsNormalizerInterface[]
     */
    private array $normalizers = [];
    private CacheKeyGeneratorInterface $cacheKeyGenerator;
    /**
     * @var OptionsResolverInterface[]
     */
    private array $optionsResolvers = [];
    private DataGeneratorInterface $dataGenerator;

    private ?DataSerializerInterface $dataSerializer = null;
    private DataTransmitterInterface $dataTransmitter;


    public function __construct(
        string                     $key,
        CacheStorageInterface      $cacheStorage,
        CacheKeyGeneratorInterface $cacheKeyGenerator,
        DataGeneratorInterface     $dataGenerator,
        DataTransmitterInterface   $dataTransmitter
    )
    {
        $this->cacheStorage = $cacheStorage;
        $this->key = $key;
        $this->cacheKeyGenerator = $cacheKeyGenerator;
        $this->dataGenerator = $dataGenerator;
        $this->dataTransmitter = $dataTransmitter;
    }

    public function update(ParamsBagInterface $paramsBag)
    {
        //TODO Заложить возможность dependency
        try {

            $options = [];

            $this
                ->validateParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_UPDATE)
                ->normalizeParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_UPDATE)
                ->resolveOptions($paramsBag, CacheMethodModelInterface::CACHE_METHOD_UPDATE,$options);

            $key = $this->generateCacheKey($paramsBag);
            $data = $this->dataGenerator->generate($paramsBag);

            $this->put(
                $paramsBag,
                $options,
                $key,
                $this->dataSerializer ?
                    $this->dataSerializer->serialize($data) :
                    $data
            );

            return $data;
        } catch (\Throwable $e) {
            //TODO Обработать ошибку и соо
            return false;
        }

    }


    protected function put(ParamsBagInterface $paramsBag, array $options, string $key, $data): void
    {
        $this->dataTransmitter->put($this->cacheStorage, $options, $key, $data);
        //TODO Dependencies
    }

    protected function getDataGenerator(): DataGeneratorInterface
    {
        return $this->dataGenerator;
    }

    public function get(ParamsBagInterface $paramsBag)
    {
        $this
            ->validateParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_GET)
            ->normalizeParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_GET)
            ;
        $data = $this->dataTransmitter->get($this->cacheStorage, $this->generateCacheKey($paramsBag));

        return $this->dataSerializer && is_string($data) ? $this->dataSerializer->unserialize($data) : $data;
    }

    public function has(ParamsBagInterface $paramsBag): bool
    {
        return $this
            ->validateParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_HAS)
            ->normalizeParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_HAS)
            ->cacheStorage
            ->has($this->generateCacheKey($paramsBag));
    }

    public function delete(ParamsBagInterface $paramsBag): bool
    {
        try {//TODO dependency
            $this
                ->validateParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_DELETE)
                ->normalizeParams($paramsBag, CacheMethodModelInterface::CACHE_METHOD_DELETE)
                ->cacheStorage
                ->delete($this->generateCacheKey($paramsBag));
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }


    public function generateCacheKey(ParamsBagInterface $paramsBag): string
    {
        return $this->cacheKeyGenerator->generate($this->key, $paramsBag);
    }
    protected function validateParams(ParamsBagInterface $paramsBag, string $action): self
    {
        foreach ($this->validators as $validator) {
            $validator->validate($paramsBag, $action);
        }

        return $this;
    }
    protected function normalizeParams(ParamsBagInterface $paramsBag, string $action): self
    {
        foreach ($this->normalizers as $normalizer) {
            $normalizer->normalize($paramsBag, $action);
        }

        return $this;
    }
    protected function resolveOptions(ParamsBagInterface $paramsBag, string $action, array &$options): self
    {
        foreach ($this->optionsResolvers as $optionsResolver) {
            $optionsResolver->resolve($paramsBag, $action, $options);
        }

        return $this;
    }

    public function addValidator($validator): self
    {
        /** @var CacheParamsValidatorInterface[] $validators */
        $validators = is_array($validator) ? $validator : [$validator];

        foreach ($validators as $validator) {

            $this->validators[] = $validator;
        }

        return $this;
    }
    public function addNormalizer($normalizer): self
    {
        $normalizers = is_array($normalizer) ? $normalizer : [$normalizer];

        foreach ($normalizers as $normalizer) {

            $this->normalizers[] = $normalizer;
        }

        return $this;
    }

    public function addOptionsResolver($resolver): self
    {
        $resolvers = is_array($resolver) ? $resolver : [$resolver];

        foreach ($resolvers as $resolver) {

            $this->optionsResolvers[] = $resolver;
        }

        return $this;
    }

    public function setDataSerializer(DataSerializerInterface $dataSerializer): self
    {
        $this->dataSerializer = $dataSerializer;

        return $this;
    }

    protected function getCacheStorage(): CacheStorageInterface
    {
        return $this->cacheStorage;
    }
}
