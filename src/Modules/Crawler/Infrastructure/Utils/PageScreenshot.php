<?php

namespace Modules\Crawler\Infrastructure\Utils;

use Modules\Crawler\Domain\Contracts\PageScreenshotInterface;
use Spatie\Browsershot\Browsershot;

class PageScreenshot implements PageScreenshotInterface
{
    const STORE_SCREENSHOT_PATH = 'app/public/screenshots/';
    const PUBLIC_SCREENSHOT_PATH = 'storage/screenshots/';

    public function capture(string $url, string $id): string
    {        
        try {
            $storePath = storage_path(self::STORE_SCREENSHOT_PATH);
            
            Browsershot::url($url)
                ->windowSize(1920, 1080)
                ->fullPage()
                ->save($storePath . $id . '.png');

            return self::PUBLIC_SCREENSHOT_PATH . $id . '.png';
        } catch (\Exception $e) {
            throw new \Exception("Failed to capture screenshot: " . $e->getMessage());
        }
    }
}