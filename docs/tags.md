# Pimcore Tags
Pimcore tags are used for tagging Pimcore elements such as assets, documents, or data objects.

Tags are utilized both for personalization and search functionality.

In general, they serve as search filter values.

Structurally, tags are essentially just strings, but they can be organized hierarchically.

In the Pimcore Toolbox, we provide a `TagFactory`, which allows creating tags from simple strings or using a filesystem-path-like notation — for example:  
`/my-root-tag/my-tag/my-sub-tag`.

This will create a tag structure with three levels:

![tag_hierarchy.png](images/tag_hierarchy.png)
