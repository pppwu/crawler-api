<?php

namespace Modules\Crawler\Presentation\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Crawler\Application\Services\CrawlService;

/**
 * Class CrawlController
 *
 * @package Modules\Crawler\Presentation\Controllers
 */
class CrawlController extends Controller
{
    /**
     * @var CrawlService
     */
    private CrawlService $crawlService;

    /**
     * CrawlController constructor.
     *
     * @param CrawlService $crawlService
     */
    public function __construct(CrawlService $crawlService)
    {
        $this->crawlService = $crawlService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {

        $url = $request->query('url');
        if (empty($url)) {
            return $this->errorResponse('URL is required', 422);
        }

        try {
            $result = $this->crawlService->crawl($url);

            return $this->successResponse($result->toArray());
        } catch (ValidationException $e) {
            return $this->errorResponse('Failed to crawl the URL', 422);
        } catch (\Throwable $e) {
            return $this->errorResponse('An unexpected error occurred. ERR: '.$e->getMessage(), 500);
        }

    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    private function successResponse(array $data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function errorResponse(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $message,
        ], $statusCode);
    }
}
