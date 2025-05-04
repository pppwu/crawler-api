<?php 

namespace Modules\Crawler\Domain\Contracts;

use Modules\Crawler\Domain\DTO\CrawlResponseDTO;

/**
 * Interface CrawlServiceInterface
 * @package Modules\Crawler\Domain\Contracts
 *
 * This interface defines the contract for the CrawlService.
 * It includes methods for crawling a URL, retrieving a crawled page by ID,
 * updating metadata, and deleting a crawled page by ID.
 */
interface CrawlServiceInterface
{
    /**
     * Crawl a given URL and save the result.
     *
     * @param string $url The URL to crawl.
     * @return CrawlResponseDTO The response containing the crawled data.
     */
    public function crawlAndSave(string $url): CrawlResponseDTO;

    /**
     * Retrieve a crawled page by its ID.
     *
     * @param string $id The ID of the crawled page.
     * @return CrawlResponseDTO The response containing the crawled data.
     */
    public function getById(string $id): CrawlResponseDTO;

    /**
     * Update the metadata of a crawled page.
     *
     * @param string $id The ID of the crawled page to update.
     * @return CrawlResponseDTO The response containing the updated crawled data.
     */
    public function updateMeta(string $id): CrawlResponseDTO;

    /**
     * Delete a crawled page by its ID.
     *
     * @param string $id The ID of the crawled page to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteById(string $id): bool;
}