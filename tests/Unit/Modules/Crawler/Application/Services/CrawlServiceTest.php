<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Crawler\Application\Services\CrawlService;
use Modules\Crawler\Domain\Contracts\HttpClientInterface;
use Modules\Crawler\Domain\Contracts\CrawlRepositoryInterface;
use Modules\Crawler\Domain\Contracts\UuidGeneratorInterface;
use Modules\Crawler\Domain\Contracts\PageScreenshotInterface;
use Modules\Crawler\Domain\DTO\CrawlResponseDTO;
use Modules\Crawler\Domain\Models\CrawledPage;

class CrawlServiceTest extends TestCase
{
    private $httpClientMock;
    private $crawlRepositoryMock;
    private $uuidGeneratorMock;
    private $pageScreenshotMock;
    private $crawlService;

    protected function setUp(): void
    {
        $this->httpClientMock = $this->createMock(HttpClientInterface::class);
        $this->crawlRepositoryMock = $this->createMock(CrawlRepositoryInterface::class);
        $this->uuidGeneratorMock = $this->createMock(UuidGeneratorInterface::class);
        $this->pageScreenshotMock = $this->createMock(PageScreenshotInterface::class);

        $this->crawlService = new CrawlService(
            $this->httpClientMock,
            $this->crawlRepositoryMock,
            $this->uuidGeneratorMock,
            $this->pageScreenshotMock
        );
    }

    public function testCrawlAndSave()
    {
        $url = 'https://example.com';
        $id = '1234-5678';
        $html = '<html><head><meta name="title" content="Example Title"><meta name="description" content="Example Description"></head></html>';
        $screenshotPath = '/screenshots/1234-5678.png';

        $this->uuidGeneratorMock->method('generate')->willReturn($id);
        $this->httpClientMock->method('get')->with($url)->willReturn($html);
        $this->pageScreenshotMock->method('capture')->with($url, $id)->willReturn($screenshotPath);
        $this->crawlRepositoryMock->method('save')->willReturn(new CrawledPage(
            id: $id,
            url: $url,
            site_meta_title: 'Example Title',
            site_meta_description: 'Example Description',
            screenshot_path: $screenshotPath,
            created_at: new \DateTime(),
            updated_at: new \DateTime()
        ));
        
        $response = $this->crawlService->crawlAndSave($url);
        
        $this->assertInstanceOf(CrawlResponseDTO::class, $response);
        $this->assertEquals($id, $response->id);
        $this->assertEquals($url, $response->url);
        $this->assertEquals('Example Title', $response->siteMetaTitle);
        $this->assertEquals('Example Description', $response->siteMetaDescription);
        $this->assertEquals($screenshotPath, $response->sreenshotPath);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $response->createdAt);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $response->updatedAt);

    }

    public function testGetById()
    {
        $id = '1234-5678';
        $page = new CrawledPage(
            id: $id,
            url: 'https://example.com',
            site_meta_title: 'Example Title',
            site_meta_description: 'Example Description',
            screenshot_path: '/screenshots/1234-5678.png',
            created_at: new \DateTime('2023-01-01 00:00:00'),
            updated_at: new \DateTime('2023-01-01 00:00:00')
        );

        $this->crawlRepositoryMock->method('findById')->with($id)->willReturn($page);

        $response = $this->crawlService->getById($id);

        $this->assertInstanceOf(CrawlResponseDTO::class, $response);
        $this->assertEquals($id, $response->id);
        $this->assertEquals('https://example.com', $response->url);
        $this->assertEquals('Example Title', $response->siteMetaTitle);
        $this->assertEquals('Example Description', $response->siteMetaDescription);
        $this->assertEquals('/screenshots/1234-5678.png', $response->sreenshotPath);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $response->createdAt);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $response->updatedAt);
    }

    public function testUpdateMeta()
    {
        $id = '1234-5678';
        $existingPage = new CrawledPage(
            id: $id,
            url: 'https://example.com',
            site_meta_title: 'Old Title',
            site_meta_description: 'Old Description',
            screenshot_path: '/screenshots/1234-5678.png',
            created_at: new \DateTime('2023-01-01 00:00:00'),
            updated_at: new \DateTime('2023-01-01 00:00:00')
        );

        $html = '<html><head><meta name="title" content="New Title"><meta name="description" content="New Description"></head></html>';
        $newScreenshotPath = '/screenshots/1234-5678-new.png';

        $this->crawlRepositoryMock->method('findById')->with($id)->willReturn($existingPage);
        $this->httpClientMock->method('get')->with($existingPage->url)->willReturn($html);
        $this->pageScreenshotMock->method('capture')->with($existingPage->url, $id)->willReturn($newScreenshotPath);

        $this->crawlRepositoryMock->expects($this->once())->method('save');

        $response = $this->crawlService->updateMeta($id);

        $this->assertInstanceOf(CrawlResponseDTO::class, $response);
        $this->assertEquals($id, $response->id);
        $this->assertEquals('https://example.com', $response->url);
        $this->assertEquals('New Title', $response->siteMetaTitle);
        $this->assertEquals('New Description', $response->siteMetaDescription);
        $this->assertEquals($newScreenshotPath, $response->sreenshotPath);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $response->createdAt);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $response->updatedAt);
    }

    public function testDeleteById()
    {
        $id = '1234-5678';

        $this->crawlRepositoryMock->method('deleteById')->with($id)->willReturn(true);

        $result = $this->crawlService->deleteById($id);

        $this->assertTrue($result);
    }
}