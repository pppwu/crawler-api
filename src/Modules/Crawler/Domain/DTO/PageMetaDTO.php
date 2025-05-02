<?php

namespace Modules\Crawler\Domain\DTO;

class PageMetaDTO
{
    /**
     * @param string|null $title
     * @param string|null $description
     */
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
    ) {}

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'site_meta_title' => $this->title ?? null,
            'site_meta_description' => $this->description ?? null,
        ];
    }
}
