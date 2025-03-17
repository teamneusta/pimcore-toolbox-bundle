<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Wrapper;

/**
 * This class is a wrapper for all static public functions of the \Pimcore class.
 */
class Pimcore
{
    public function inDevMode(): bool
    {
        return \Pimcore::inDevMode();
    }

    /**
     * Checks if the process is currently in admin mode or not.
     */
    public function inAdmin(): bool
    {
        return \Pimcore::inAdmin();
    }

    public static function isInstalled(): bool
    {
        return \Pimcore::isInstalled();
    }

    /**
     * Forces a garbage collection.
     *
     * @param string[] $keepItems
     */
    public function collectGarbage(array $keepItems = []): void
    {
        \Pimcore::collectGarbage($keepItems);
    }

    /**
     * Deletes temporary files which got created during the runtime of the current process.
     */
    public function deleteTemporaryFiles(): void
    {
        \Pimcore::deleteTemporaryFiles();
    }
}
