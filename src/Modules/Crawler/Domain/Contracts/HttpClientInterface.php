<?php

namespace Modules\Crawler\Domain\Contracts;

/**
 * Interface HttpClientInterface
 * @package Modules\Crawler\Domain\Contracts
 *
 * This interface defines the contract for an HTTP client that can be used to make GET requests.
 */
interface HttpClientInterface
{
    /**
     * Make a GET request to the specified URL.
     *
     * @param string $url The URL to fetch.
     * @return string The response body.
     * @throws \RuntimeException If the request fails.
     */
    public function get(string $url): string;
}