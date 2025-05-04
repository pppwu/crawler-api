<?php

namespace Modules\Crawler\Domain\DTO;

/**
 * Class CrawlRequestDTO
 * @package Modules\Crawler\Domain\DTO
 *
 * This class represents a data transfer object (DTO) for a crawl request.
 * It contains the URL to be crawled.
 */
class CrawlRequestDTO
{
    /**
     * @param string $url
     */
    public function __construct(
        public readonly string $url,
    ) {}
}