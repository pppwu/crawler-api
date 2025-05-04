<?php

namespace Modules\Crawler\Domain\DTO;

class CrawlResponseDTO
{
    /**
     * @param string $id
     * @param string $url
     * @param string|null $title
     * @param string|null $description
     * @param string|null $sreenshotPath
     */
    public function __construct(
        public readonly string $id,
        public readonly string $url,
        public readonly ?string $siteMetaTitle,
        public readonly ?string $siteMetaDescription,
        public readonly ?string $sreenshotPath,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
    ) {}

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
