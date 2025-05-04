<?php

namespace Modules\Crawler\Domain\Models;

use Modules\Crawler\Domain\Contracts\TimeInterface;

/**
 * Class CrawledPage
 * @package Modules\Crawler\Domain\Models
 *
 * This class represents a crawled page with its metadata.
 */
class CrawledPage
{
    /**
     * @param string $id
     * @param string $url
     * @param string|null $site_meta_title
     * @param string|null $site_meta_description
     * @param string|null $screenshot_path
     * @param \DateTime|null $created_at
     * @param \DateTime|null $updated_at
     */
    public function __construct(
        public readonly string $id,
        public readonly string $url,
        public readonly ?string $site_meta_title,
        public readonly ?string $site_meta_description,
        public readonly ?string $screenshot_path,
        public readonly ?\DateTime $created_at,
        public readonly ?\DateTime $updated_at,
    ) {
    }
}