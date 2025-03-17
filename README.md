# Pimcore Toolbox Bundle

Provides common helper classes useful for Pimcore development.

[[_TOC_]]

## Installation

1.  **Require the bundle**

    ```shell
    composer require teamneusta/pimcore-toolbox-bundle
    ```

2.  **Enable the bundle**

    Add the bundle to your `config/bundles.php`:

    ```php
    Neusta\Pimcore\ToolboxBundle\PimcoreToolboxBundle::class => ['all' => true],
    ```

## Available helpers

Currently, there are some static helpers that aid with versioning, inheritance and access to unpublished assets, data objects and documents.

While Pimcore itself only allows to globally enable/disable those features and resetting them to the previous state after the operation is a repetitive and boring task,
these helpers will take care of it – you just have to pass a callable with the desired operations.

### Cache (assets, document, data objects)

This helper allows executing your operations with enabled/disabled cache:

```php
$fetchObject = fn () => Pimcore\Model\DataObject::getById(123);

$object = Neusta\Pimcore\ToolboxBundle\Cache::withEnabledCache($fetchObject);
$object = Neusta\Pimcore\ToolboxBundle\Cache::withDisabledCache($fetchObject);
```

You may pass as many arguments as you want to the callable:

```php
class ObjectRepository {
    public function fetch(int $objectId) {
        return Pimcore\Model\DataObject::getById($objectId);
    }
}

$object = Neusta\Pimcore\ToolboxBundle\Cache::withEnabledCache([new ObjectRepository(), 'fetch'], 123, 'data');
$object = Neusta\Pimcore\ToolboxBundle\Cache::withEnabledCache([new ObjectRepository(), 'fetch'], 123, 'data');
```

### Versioning (assets, document, data objects)

This helper allows executing your operations with enabled/disabled versioning:

```php
$object = Pimcore\Model\DataObject::getById(123);
$object->setSomeData('data');

$saveObject = fn () => $object->save();

Neusta\Pimcore\ToolboxBundle\Versioning::withVersioning($saveObject);
Neusta\Pimcore\ToolboxBundle\Versioning::withoutVersioning($saveObject);
```

You may pass as many arguments as you want to the callable:

```php
class ObjectManipulator {
    public function manipulateObject(int $id, string $data): bool {
        $object = Pimcore\Model\DataObject::getById($id);
        $object->setSomeData($data);

        try {
            $object->save();
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }
}

$success = Neusta\Pimcore\ToolboxBundle\Versioning::withVersioning([new ObjectManipulator(), 'manipulateObject'], 123, 'data');
$success = Neusta\Pimcore\ToolboxBundle\Versioning::withoutVersioning([new ObjectManipulator(), 'manipulateObject'], 123, 'data');
```

### Commands

Sometimes you have several commands which have been implemented separately for reasons of Separation of Concerns,
but in a work environment you need to run them together.

This helper allows you to run several commands in one go.

```yaml
  my.batch.command:
      class: Neusta\Pimcore\ToolboxBundle\Command\BatchCommand
      arguments:
          $name: 'all:my:commands'
          $commands:
              - command: 'my:command:1'
              - command: 'my:command:2'
              - command: 'my:command:3'
                arguments:
                    arg1: 'value1'
                    arg2: 'value2'
                options:
                    --option1: 'value1'
                    --option2: 'value2'
      tags: [ 'console.command' ]
```

And after that you can run: `bin/console all:my:commands`

### Inheritance (data objects)

This helper allows executing your operations with enabled/disabled inheritance:

```php
$object = Pimcore\Model\DataObject::getById(123);

$getData = fn () => $object->getSomeData();

$data = Neusta\Pimcore\ToolboxBundle\DataObject\Inheritance::withInheritedValues($getData);
$data = Neusta\Pimcore\ToolboxBundle\DataObject\Inheritance::withoutInheritedValues($getData);
```

You may pass as many arguments as you want to the callable:

```php
class DataProvider {
    public function fetchData(int $objectId) {
        return Pimcore\Model\DataObject::getById($objectId)->getSomeData();
    }
}

$data = Neusta\Pimcore\ToolboxBundle\DataObject\Inheritance::withInheritedValues([new DataProvider(), 'fetchData'], 123);
$data = Neusta\Pimcore\ToolboxBundle\DataObject\Inheritance::withoutInheritedValues([new DataProvider(), 'fetchData'], 123);
```

### Localized field (data objects)

This helper allows executing your operations with enabled/disabled fallback values:

```php
$object = Pimcore\Model\DataObject::getById(123);

$getSomeLocalizedField = fn () => $object->getSomeLocalizedField();

$data = Neusta\Pimcore\ToolboxBundle\DataObject\LocalizedField::withFallbackValues($getSomeLocalizedField);
$data = Neusta\Pimcore\ToolboxBundle\DataObject\LocalizedField::withoutFallbackValues($getSomeLocalizedField);
```

You may pass as many arguments as you want to the callable:

```php
class DataProvider {
    public function fetchData(int $objectId) {
        return Pimcore\Model\DataObject::getById($objectId)->getSomeLocalizedField();
    }
}

$data = Neusta\Pimcore\ToolboxBundle\DataObject\LocalizedField::withFallbackValues([new DataProvider(), 'fetchData'], 123);
$data = Neusta\Pimcore\ToolboxBundle\DataObject\LocalizedField::withoutFallbackValues([new DataProvider(), 'fetchData'], 123);
```

### Publishing (data objects)

This helper allows executing your operations with inclusion/exclusion of unpublished objects.

```php
$getObjects = fn () => (new Pimcore\Model\DataObject\Listing())->getObjects();

$objects = Neusta\Pimcore\ToolboxBundle\DataObject\Publishing::withUnpublishedObjects($getObjects);
$objects = Neusta\Pimcore\ToolboxBundle\DataObject\Publishing::withoutUnpublishedObjects($getObjects);
```

You may pass as many arguments as you want to the callable:

```php
class ObjectRepository {
    public function findByCondition(string $value): array {
        $listing = new Pimcore\Model\DataObject\Listing();
        $listing->setCondition('some_row = ?', [$value]);

        return $listing->getObjects();
    }
}

$objects = Neusta\Pimcore\ToolboxBundle\DataObject\Publishing::withUnpublishedObjects([new ObjectRepository(), 'findByCondition'], 'value');
$objects = Neusta\Pimcore\ToolboxBundle\DataObject\Publishing::withoutUnpublishedObjects([new ObjectRepository(), 'findByCondition'], 'value');
```

### Publishing (documents)

This helper allows executing your operations with inclusion/exclusion of unpublished documents.

```php
$getDocuments = fn () => (new Pimcore\Model\Document\Listing())->getDocuments();

$documents = Neusta\Pimcore\ToolboxBundle\Document\Publishing::withUnpublishedDocuments($getDocuments);
$documents = Neusta\Pimcore\ToolboxBundle\Document\Publishing::withoutUnpublishedDocuments($getDocuments);
```

You may pass as many arguments as you want to the callable:

```php
class DocumentRepository {
    public function findByCondition(string $value): array {
        $listing = new Pimcore\Model\Document\Listing();
        $listing->setCondition('some_row = ?', [$value]);

        return $listing->getDocuments();
    }
}

$documents = Neusta\Pimcore\ToolboxBundle\Document\Publishing::withUnpublishedDocuments([new DocumentRepository(), 'findByCondition'], 'value');
$documents = Neusta\Pimcore\ToolboxBundle\Document\Publishing::withoutUnpublishedDocuments([new DocumentRepository(), 'findByCondition'], 'value');
```

### [Repositories (assets, document, data objects)](docs/repositories.md)

### [Wrapper for static methods](docs/wrappers.md)

### [Classification Values](docs/classification.md)

### File Size Calculation
Sometimes you need the size of an asset or an image; i.e. the size of the physical file behind this elements.

Therefore, we offer a new Service called `Neusta\Pimcore\ToolboxBundle\Service\FileSizeService`. This service offers a method called `getFileSize` which returns the size of the file in bytes.

But as you can read [here](https://en.wikipedia.org/wiki/Byte#Multiple-byte_units) it is not that easy. You can decide if you want to get the size of the file in bytes, kilobytes, megabytes or gigabytes or use IEC compatible units (KiB, MiB, GiB).

## Using helpers in migration classes

Create a public alias for the service you need:
```YAML
# config/services.yaml
services:
    # ...

    app.toolbox.select_factory:
        alias: Neusta\Pimcore\ToolboxBundle\Factory\SelectFactory
        public: true
```

Implement the `ContainerAwareInterface` and use the `ContainerAwareTrait`. Now you can fetch the service:
```PHP
// ...

final class Version20770101141207 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function up(Schema $schema): void
    {
        $factory = $this->container->get('app.toolbox.select_factory');

        // ...
    }

    // ...
}
```

Keep in mind that this approach is deprecated since Symfony 6.4 and won't work with Symfony 7, but there isn't really  
a replacement at the moment (see: https://github.com/doctrine/DoctrineMigrationsBundle/issues/521).

## Contribution

Feel free to open issues for any bug, feature request, or other ideas.

Please remember to create an issue before creating large pull requests.

### Local Development

To develop on a local machine, the vendor dependencies are required.

```shell
bin/composer install
```

We use composer scripts for our main quality tools. They can be executed via the `bin/composer` file as well.

```shell
bin/composer cs:fix
bin/composer phpstan
```

For the tests there is a different script, that includes a database setup.

```shell
bin/run-tests
```
