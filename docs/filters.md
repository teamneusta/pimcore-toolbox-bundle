# Filters

Very often, in our Pimcore environment, we deal with collections of objects that need to be pre-filtered based on specific criteria before they are used.

Typical scenarios include: retrieving all published CMS pages or returning all DataObjects where the attribute 'status' has the value 'new'.

And just as often, we need these filtering criteria in multiple places and end up implementing them repeatedly. This can naturally lead to errors and inconsistency, which could have been avoided by using predefined filters — such as Symfony services in dedicated classes like Providers or Repositories — that always ensure the same behavior.

From now on, whenever you need to filter collections of objects, you will use an injected object of type Filter in your implementation. This object can be injected via Symfony and properly assembled outside your class.

Some typical cases — such as logically combining filters using AND or OR — are already implemented. This makes uniform usage even easier.

From now on, you can focus on implementing specific checks, filtering based on particular properties or object states, thoroughly testing each granular filter, and then combining them into a new composite filter.

Just keep in mind that the logic of all filters follows the same principle: **filtering an element means it will be kept in the collection**.

It's a bit like being in court: if you're guilty, you're in jail.

## Common Filters

### Filter by Property Value

The PropertyValueFilter allows filtering based on a specific value in two ways:

1. Standard filtering (default behavior): If the property matches the given value, the object is accepted. In this case, set the constructor parameter `$filtered` to `true`.
2. Inverse filtering: If the property does match the given value, the object is filtered out. To enable this behavior, set `$accepted` to `false`.

### Filter by Property Range

The PropertyRangeFilter allows filtering based on a range of values (closed interval). The filter checks if the property value is within the given range. If the property value is within the range, the object is in the list (`$accepted = true`).

Inverse filtering is also possible (`$accepted = false`). In this case, the object is denied if the property value is inside the range.

### Property Pattern Filter

The `PropertyPatternFilter` allows specifying a search pattern for a string property, which must either be matched (`$accepted = true`) or not matched (`$accepted = false`).

### Callable Filter

The `CallableFilter` enables passing a closure during instantiation, whose result is either true or false, determining whether the object is included or filtered out accordingly.

### TypeFilter

The `TypeFilter` checks if the object is of a specific type. If the object is of the specified type, it is included in the list (`$accepted = true`). If the object is not of the specified type, it is filtered out. The other way round if you use `$accepted = false`.

## Pimcore Filters

### PropertyFilter

The `PropertyFilter` allows filtering based on a property value based upon the Pimcore Element feature of `properties`.
