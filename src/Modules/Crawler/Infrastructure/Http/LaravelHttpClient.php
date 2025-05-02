<?php

namespace Modules\Crawler\Infrastructure\Http;

use Modules\Crawler\Domain\Contracts\HttpClientInterface;
use Illuminate\Support\Facades\Http;

/**
 * Class LaravelHttpClient
 *
 * @package Modules\Crawler\Infrastructure\Http
 */
class LaravelHttpClient implements HttpClientInterface
{
    /**
     * Send a GET request to the specified URL and return the response body.
     *
     * @param string $url
     * @return string
     */
    public function get(string $url): string
    {
        $response = Http::get($url);

        return $response->body();
    }
}