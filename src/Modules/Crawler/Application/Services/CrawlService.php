<?php

namespace Modules\Crawler\Application\Services;

use Modules\Crawler\Domain\Contracts\HttpClientInterface;
use Modules\Crawler\Domain\DTO\PageMetaDTO;

/**
 * Class CrawlService
 *
 * @package Modules\Crawler\Application\Services
 */

class CrawlService
{
    private HttpClientInterface $httpClient;

    /**
     * CrawlService constructor.
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        HttpClientInterface $httpClient
    )
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Crawl the given URL and extract the page meta information.
     *
     * @param string $url
     * @return PageMetaDTO
     */
    public function crawl(string $url): PageMetaDTO
    {
        $html = $this->httpClient->get($url);

        $title = null;
        $description = null;

        if (preg_match('/<meta name="title" content="(.*?)"/', $html, $matches)) {
            $title = $matches[1];
        }
        if (preg_match('/<meta name="description" content="(.*?)"/', $html, $matches)) {
            $description = $matches[1];
        }

        return new PageMetaDTO($title,$description);
    }
}