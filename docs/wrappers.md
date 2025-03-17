# Wrapper for static methods

> [!NOTE]
> These wrappers have been implemented to allow mocking Pimcore behaviour in unit tests without running Pimcore
> platform. So use them instead of basic Pimcore classes with static methods and don not hesitate to add missing but
> needed wrappers.

There are also several wrappers for static methods from Pimcore:

| FQN of the Wrapper class                                      | FQN of the Pimcore class       |
|---------------------------------------------------------------|--------------------------------|
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Admin`                  | `Pimcore\Admin`                |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Config`                 | `Pimcore\Config`               |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\File`                   | `Pimcore\File`                 |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Frontend`               | `Pimcore\Frontend`             |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Image`                  | `Pimcore\Image`                |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Pimcore`                | `Pimcore\Pimcore`              |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\SystemSettingsConfig`   | `Pimcore\SystemSettingsConfig` |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Tool`                   | `Pimcore\Tool`                 |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Model\Site`             | `Pimcore\Model\Site`           |
| `Neusta\Pimcore\ToolboxBundle\Wrapper\Model\Element\Tag`      | `Pimcore\Model\Element\Tag`    |

> [!TIP]
> If you implement a new wrapper class use at most `Neusta\Pimcore\ToolboxBundle\Wrapper\XXX` instead `Pimcore\XXX` as
> namespace.
