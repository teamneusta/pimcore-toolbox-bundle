# Classification Values

For Classification Stores and their config groups, key config groups and values you can use the following associated repositories and/or factories.

## Repositories
- `GroupConfigRepository`
- `KeyConfigRepository`
- `KeyGroupRelationRepository`
- `StoreConfigRepository`

If you need to find or get artifacts by name, use the Repositories in the following manner:
```php
public function __construct(
    private StoreConfigRepository $storeConfigRepository,
    private GroupConfigRepository $groupConfigRepository,
    private KeyConfigRepository $keyConfigRepository,
){}
```
```php
$storeId = $this->storeConfigRepository->getByName('my classification store')->getId();

$groupConfig = $this->groupConfigRepository->getByName('my group config name', $storeId);
$keyConfig = $this->keyConfigRepository->getByName('my key config name', $storeId);
```

## Factories
- `ClassificationstoreFactory`
- `GroupConfigFactory`
- `KeyConfigFactory`
- `KeyGroupRelationFactory`
- `StoreConfigFactory`
- `InputFactory`
- `SelectFactory`

An example for creating a new set of selectable values in a classification store would look like this:
```php
public function __construct(
    private StoreConfigFactory $storeConfigFactory,
    private ClassificationstoreFactory $classificationstoreFactory,
    private SelectFactory $selectFactory,
){}
```
```php
$storeConfig = $storeConfigFactory->create('my classification store');

[$keyConfig, $groupConfig]
    = $classificationstoreFactory->createNewEntriesForClassificationValues(
        'my key config name',
        $selectFactory->create(
            'name of select field',
            'title of select field',
            [
                ['key' => 'key.select.value.1', 'value' => 'first value'],
                ['key' => 'key.select.value.2', 'value' => 'second value'],
                ['key' => 'key.select.value.3', 'value' => 'third value'],
            ],
        ),
        $storeConfig,
        'Created by myself',
    );
```

