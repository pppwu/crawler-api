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
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $sreenshotPath,
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
