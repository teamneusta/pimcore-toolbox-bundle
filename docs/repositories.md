# Repositories

There are repositories for each of Pimcore's element types:
- `\Neusta\Pimcore\ToolboxBundle\Repository\AssetRepository`
- `\Neusta\Pimcore\ToolboxBundle\Repository\DataObjectRepository`
- `\Neusta\Pimcore\ToolboxBundle\Repository\DocumentRepository`
- `\Neusta\Pimcore\ToolboxBundle\Repository\PageRepository`

Those repositories are wrappers for the static "repository" methods on the element objects.

You can use them, for example, to retrieve a data object in a non-static way:

```php
$dataObjectRepository = new \Neusta\Pimcore\ToolboxBundle\Repository\DataObjectRepository();

$dataObject = $dataObjectRepository->getById(123);
```
