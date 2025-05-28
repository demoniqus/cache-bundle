## Терминология

- Сервис кеширования - сервис, ответственный за работу с конкретным набором данных. Данный сервис выполняет расчет конкретных данных,
генерирует ключи для доступа к этим данным в хранилище, выполняет проверку наличия данных в хранилище по ключу и очистку данных.
- Шина передачи данных - сервис, ответственный за отправку данных в хранилище. Разные хранилища могут работать с разными формами данных,
по разным протоколам и т.д. Шина передачи данных является посредником между сервисом кеширования и хранилищем.
- Зависимость сервиса кеширования - формализованное правило, позволяющее описать зависимость сервиса кеширования от изменения данных.
- Ключ данных - уникальный ключ для доступа к данным внутри хранилища данных. Полный ключ включает в себя идентификаторы сервиса кеширования,
параметры для расчета, в т.ч. идентификатор базовой сущности, и пр. информацию.
- Хранилище данных - внешний сервис, ответственный за непосредственное хранение данных
- Сервис хранилища данных - сервис, ответственный за непосредственную работу с внешним хранилищем данных

## Описание структуры классов

- Demoniqus\CacheBundle\Cache\CacheServiceInterface - интерфейс сервиса кеширования.
- Demoniqus\CacheBundle\Cache\BaseCacheService - базовый сервис кеширования
- Demoniqus\CacheBundle\Interfaces\Common\DataTransmitterInterface - интерфейс шины передачи данных
- Demoniqus\CacheBundle\DataTransmitter\[HashedDataTransmitter|StringedDataTransmitter] - шины передачи данных
- Demoniqus\CacheBundle\Interfaces\Common\CacheServiceDependencyInterface - интерфейс зависимости сервиса кеширования
- Demoniqus\CacheBundle\Dependencies\Dependency\AbstractCacheServiceDependency - абстрактный класс, описывающий зависимость сервиса кеширования
- Demoniqus\CacheBundle\Interfaces\DependedCacheServicesResolverInterface - интерфейс resolver'а зависимостей сервисов кеширования
- Demoniqus\CacheBundle\Dependencies\Resolver\DependedCacheServicesResolver - resolver зависимостей сервисов кеширования
- Demoniqus\CacheBundle\Factory\[ServicesFactoryInterface|ServicesFactory] - интерфейс и фабрика сервисов кеширования
- Demoniqus\CacheBundle\Interfaces\Common\CacheInterface - базовый интерфейс для взаимодействия с хранилищем данных
- Demoniqus\CacheBundle\Interfaces\Common\CacheKeyGeneratorInterface - базовый интерфейс генератора ключей данных
- Demoniqus\CacheBundle\Interfaces\Common\CacheMethodModelInterface - модель доступных операций с данными кеша
- Demoniqus\CacheBundle\Interfaces\Common\CacheParamsNormalizerInterface - интерфейс нормализатора параметров для сервиса кеширования
- Demoniqus\CacheBundle\Interfaces\Common\CacheParamsValidatorInterface - интерфейс валидатора параметров для сервиса кеширования
- Demoniqus\CacheBundle\Interfaces\Common\CacheStorageInterface - интерфейс сервиса хранилища данных
- Demoniqus\CacheBundle\Interfaces\Common\DataGeneratorInterface - интерфейс генератора данных кеша
- Demoniqus\CacheBundle\Interfaces\Common\DataSerializerInterface - интерфейс сериализатора данных кеша
- Demoniqus\CacheBundle\Interfaces\Common\OptionsResolverInterface - интерфейс сервиса, ответственного за работу с опциями для сервиса кеширования (например, за опцию времени жизни кеша)

## Сервис кеширования

### Конфигурация

> cache.report.entity_data:\
&emsp;class: Demoniqus\CacheBundle\Cache\BaseCacheService\
&emsp;public: true\
&emsp;arguments:\
&emsp;&emsp;$key: 'some unique cache service id''\
&emsp;&emsp;Demoniqus\CacheBundle\Interfaces\Common\CacheKeyGeneratorInterface: '@Demoniqus\CacheBundle\Interfaces\Common\CacheKeyGeneratorInterface'\
&emsp;&emsp;Demoniqus\CacheBundle\Interfaces\Common\DataGeneratorInterface: '@Demoniqus\CacheBundle\Interfaces\Common\DataGeneratorInterface'\
&emsp;tags:\
> &emsp;&emsp;&ndash; name: !php/const Demoniqus\CacheBundle\Interfaces\BundleConstantsModelInterface::CACHE_SERVICE_TAG\
&emsp;&emsp;&emsp;alias: 'some unique alias'\
&emsp;calls:\
>&emsp;&emsp;&ndash; [ 'addOptionsResolver', [['Demoniqus\CacheBundle\Interfaces\Common\OptionsResolverInterface']]]\
>&emsp;&emsp;&ndash; [ 'addNormalizer', [['@Cache\Normalizer\Report\Budget\StageDataParamsNormalizer']]]\
>&emsp;&emsp;&ndash; [ 'addValidator', [['@Cache\Validator\StageDataCacheParamsValidator']]]\
>&emsp;&emsp;&ndash; [ 'setDataSerializer', ['@cache.data_serializer.default' ]]\

### Аргументы

- $key - уникальный идентификатор сервиса кеширования. Данный идентификатор используется при идентификации данных в хранилище
- @Demoniqus\CacheBundle\Interfaces\Common\CacheKeyGeneratorInterface - сервис, отвечающий за генерацию уникального ключа для данных
- @Demoniqus\CacheBundle\Interfaces\Common\DataGeneratorInterface - сервис, отвечающий за генерацию данных

Сервис кеширования в обязательном порядке отмечается тегом ___Demoniqus\CacheBundle\Interfaces\BundleConstantsModelInterface::CACHE_SERVICE_TAG___. 
Поскольку сервисы представлены в виде реализации одного базового Demoniqus\CacheBundle\Cache\BaseCacheService (либо его наследника) с
набором разным настроек и вспомогательных сервисов, то для обращения к конкретному сервису через фабрику можно задать некоторый уникальный alias.
Этот alias не обязательно должен совпадать с аргументом $key. Если alias не задан, то сервис кеширования будет зарегистрирован в фабрике под
дефолтным наименованием, использованным в конфиге (выше в конфигурации это будет ___cache.report.entity_data___)

### Методы
- update - отвечает за обновление данных. Возвращает при успешном выполнении рассчитанные данные, в случае ошибки - false
- get - отвечает за получение данных из хранилища. Если данных в хранилище нет (отсутствует ключ), не возвращает ничего и при этом
не выполняет автоматический расчет данных.
- has - проверяет наличие данных в хранилище
- delete - выполняет удаление данных из хранилища

## Зависимость сервиса кеширования

### Конфигурация
> Cache\Dependency\BudgetCache\EstimateCust\DependencyFromDD:\
>&emsp;arguments:\
>&emsp;&emsp;Demoniqus\CacheBundle\Cache\CacheServiceInterface: '@Demoniqus\CacheBundle\Cache\CacheServiceInterface'\
>&emsp;&emsp;$dependsOn: 'Some\Entity\ClassOrInterface'\
>&emsp;tags: ['%dependedCacheServiceTag%']

### Аргументы

- @Demoniqus\CacheBundle\Cache\CacheServiceInterface - сервис кеширования
- $dependOn - наименование класса или интерфейса, от изменения данных которого зависит указанный сервис кеширования

Зависимость сервиса кеширования в обязательном порядке отмечается тегом  ___Demoniqus\CacheBundle\Interfaces\BundleConstantsModelInterface::CACHE_DEPENDENCY_TAG___
или ___%dependedCacheServiceTag%___
