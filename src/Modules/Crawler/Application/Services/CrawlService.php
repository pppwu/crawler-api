<?php 

namespace Modules\Crawler\Application\Services;

use Modules\Crawler\Domain\Contracts\CrawlServiceInterface;
use Modules\Crawler\Domain\Contracts\HttpClientInterface;
use Modules\Crawler\Domain\Contracts\CrawlRepositoryInterface;
use Modules\Crawler\Domain\Contracts\UuidGeneratorInterface;
use Modules\Crawler\Domain\DTO\CrawlResponseDTO;
use Modules\Crawler\Domain\Models\CrawledPage;
use Modules\Crawler\Domain\Contracts\PageScreenshotInterface;

class CrawlService implements CrawlServiceInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private CrawlRepositoryInterface $crawlRepository,
        private UuidGeneratorInterface $uuidGenerator,
        private PageScreenshotInterface $pageScreenshot
    ) {}

    public function crawlAndSave(string $url): CrawlResponseDTO
    {
        $id = $this->uuidGenerator->generate();
        
        $html = $this->httpClient->get($url);

        $title = $this->extractMetaTags($html, 'title');
        $description = $this->extractMetaTags($html, 'description');
        $screenshotPath = $this->captureScreenshot($url, $id);

        $page = new CrawledPage(
            id: $id,
            url: $url,
            site_meta_title: $title,
            site_meta_description: $description,
            screenshot_path: $screenshotPath,
            created_at: new \DateTime(),
            updated_at: new \DateTime(),
        );

        $this->crawlRepository->save($page);

        return new CrawlResponseDTO(
            id: $page->id,
            url: $page->url,
            siteMetaTitle: $page->site_meta_title,
            siteMetaDescription: $page->site_meta_description,
            sreenshotPath: $page->screenshot_path,
            createdAt: $page->created_at->format('Y-m-d H:i:s'),
            updatedAt: $page->updated_at->format('Y-m-d H:i:s')
        );
    }

    public function getById(string $id): CrawlResponseDTO
    {
        $page = $this->crawlRepository->findById($id);

        return new CrawlResponseDTO(
            id: $page->id,
            url: $page->url,
            siteMetaTitle: $page->site_meta_title,
            siteMetaDescription: $page->site_meta_description,
            sreenshotPath: $page->screenshot_path,
            createdAt: $page->created_at->format('Y-m-d H:i:s'),
            updatedAt: $page->updated_at->format('Y-m-d H:i:s')
        );
    }

    public function updateMeta(string $id): CrawlResponseDTO
    {
        $existingPage = $this->crawlRepository->findById($id);

        if (! $existingPage) {
            throw new \RuntimeException("Page with ID {$id} not found");
        }

        $html = $this->httpClient->get($existingPage->url);

        $newTitle = $this->extractMetaTags($html, 'title');
        $newDescription = $this->extractMetaTags($html, 'description');
        $newScreenshotPath = $this->captureScreenshot($existingPage->url, $existingPage->id);

        $newPage = new CrawledPage(
            id: $existingPage->id,
            url: $existingPage->url,
            site_meta_title: $newTitle,
            site_meta_description: $newDescription,
            screenshot_path: $newScreenshotPath,
            created_at: $existingPage->created_at,
            updated_at: new \DateTime(),
        );

        $this->crawlRepository->save($newPage);

        return new CrawlResponseDTO(
            id: $newPage->id,
            url: $newPage->url,
            siteMetaTitle: $newPage->site_meta_title,
            siteMetaDescription: $newPage->site_meta_description,
            sreenshotPath: $newPage->screenshot_path,
            createdAt: $newPage->created_at->format('Y-m-d H:i:s'),
            updatedAt: $newPage->updated_at->format('Y-m-d H:i:s')
        );
    }

    public function deleteById(string $id): bool
    {
        return $this->crawlRepository->deleteById($id);
    }

    private function extractMetaTags(string $html, string $name): ?string
    {
        $pattern = '/<meta\s+name\s*=\s*"'.preg_quote($name, '/').'"[^>]*content\s*=\s*"([^"]*)"/i';
        if (preg_match_all($pattern, $html, $matches)) {
            return $matches[1][0] ?? null;
        }

        return null;
    }

    private function captureScreenshot(string $url, string $id): ?string
    {
        return $this->pageScreenshot->capture($url, $id);
    }
}