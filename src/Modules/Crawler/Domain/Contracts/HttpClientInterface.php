<?php

namespace Modules\Crawler\Domain\Contracts;

/**
 * Interface HttpClientInterface
 *
 * @package Modules\Crawler\Domain\Contracts
 */
interface HttpClientInterface
{
    public function get(string $url): string;
}