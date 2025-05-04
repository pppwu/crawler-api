<?php

namespace Modules\Crawler\Infrastructure\Http;

use Illuminate\Support\Facades\Http;
use Modules\Crawler\Domain\Contracts\HttpClientInterface;

/**
 * Class LaravelHttpClient
 * @package Modules\Crawler\Infrastructure\Http
 *
 * This class is responsible for making HTTP requests using Laravel's HTTP client.
 */
class LaravelHttpClient implements HttpClientInterface
{
    /**
     * Make a GET request to the specified URL.
     *
     * @param string $url The URL to fetch.
     * @param array $headers Optional headers to include in the request.
     * @return string The response body.
     * @throws \RuntimeException If the request fails.
     */
    public function get(string $url, array $headers = []): string
    {

        $response = Http::get($url);

        if (! $response->successful()) {
            throw new \RuntimeException('Failed to fetch the URL: ' . $url);
        }

        return $response->body();
    }
}