<?php

namespace Modules\Crawler\Domain\Contracts;

use Modules\Crawler\Domain\Models\CrawledPage;

/**
 * Interface CrawlRepositoryInterface
 *
 * This interface defines the contract for a repository that handles the storage and retrieval of crawled pages.
 */
interface CrawlRepositoryInterface
{
    /**
     * Save a crawled page to the repository.
     *
     * @param CrawledPage $page The crawled page to save.
     * @return CrawledPage The saved crawled page.
     */
    public function save(CrawledPage $page): CrawledPage;

    /**
     * Update the metadata of a crawled page.
     *
     * @param string $id The ID of the crawled page to update.
     * @param array $meta The metadata to update.
     * @return CrawledPage The updated crawled page.
     */
    public function findById(string $id): ?CrawledPage;

    /**
     * Delete a crawled page by its ID.
     *
     * @param string $id The ID of the crawled page to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteById(string $id): bool;
}