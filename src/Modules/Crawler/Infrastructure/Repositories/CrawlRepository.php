<?php 

namespace Modules\Crawler\Infrastructure\Repositories;

use Modules\Crawler\Domain\Contracts\CrawlRepositoryInterface;
use Modules\Crawler\Domain\Models\CrawledPage;
use Illuminate\Support\Facades\DB;

/**
 * Class CrawlRepository
 * @package Modules\Crawler\Infrastructure\Repositories
 *
 * This class is responsible for interacting with the database to save, find, and delete crawled pages.
 */
class CrawlRepository implements CrawlRepositoryInterface
{
    /**
     * Save a crawled page to the repository.
     *
     * @param CrawledPage $page The crawled page to save.
     * @return CrawledPage The saved crawled page.
     */
    public function save(CrawledPage $page): CrawledPage
    {
        DB::table('crawled_pages')->updateOrInsert(
            ['id' => $page->id],
            [
                'url' => $page->url,
                'site_meta_title' => $page->site_meta_title,
                'site_meta_description' => $page->site_meta_description,
                'screenshot_path' => $page->screenshot_path,
                'created_at' => $page->created_at,
                'updated_at' => $page->updated_at
            ]
        );

        return $page;
    }

    /**
     * Update the metadata of a crawled page.
     *
     * @param string $id The ID of the crawled page to update.
     * @param array $meta The metadata to update.
     * @return CrawledPage The updated crawled page.
     */
    public function findById(string $id): ?CrawledPage
    {
        $crawledPage = DB::table('crawled_pages')->where('id', $id)->first();

        if (!$crawledPage) {
            return null;
        }

        return new CrawledPage(
            id: $crawledPage->id,
            url: $crawledPage->url,
            site_meta_title: $crawledPage->site_meta_title,
            site_meta_description: $crawledPage->site_meta_description,
            screenshot_path: $crawledPage->screenshot_path,
            created_at: new \DateTime($crawledPage->created_at),
            updated_at: new \DateTime($crawledPage->updated_at)
        );
    }

    /**
     * Delete a crawled page by its ID.
     *
     * @param string $id The ID of the crawled page to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteById(string $id): bool
    {
        return DB::table('crawled_pages')->where('id', $id)->delete() > 0;
    }
}