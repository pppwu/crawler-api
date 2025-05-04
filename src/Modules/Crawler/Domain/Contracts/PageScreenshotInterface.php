<?php

namespace Modules\Crawler\Domain\Contracts;

/**
 * Interface PageScreenshotInterface
 * @package Modules\Crawler\Domain\Contracts
 *
 * This interface defines the contract for a service that captures screenshots of web pages.
 */
interface PageScreenshotInterface
{
    /**
     * Capture a screenshot of the specified URL.
     *
     * @param string $url The URL of the page to capture.
     * @return string The path to the saved screenshot.
     */
    public function capture(string $url, string $id): string;
}