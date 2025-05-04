<?php

namespace Modules\Crawler\Presentation\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Modules\Crawler\Application\Services\CrawlService;

/**
 * Class CrawlController
 *
 * @package Modules\Crawler\Presentation\Controllers
 */
class CrawlController extends Controller
{
    public function __construct(
        private CrawlService $crawlService
    ) {}

    public function store(Request $request): JsonResponse
    {
        try {
            $url = $request->input('url');
            $validator = Validator::make(['url' => $url], [
                'url' => 'required|url',
            ]);
            $validatedData = $validator->validated();
            $result = $this->crawlService->crawlAndSave($validatedData['url']);

            return $this->successResponse($result->toArray());
        } catch (ValidationException $e) {
            return $this->errorResponse('A validation excepion. ERR: ' . $e->getMessage(), 422);
        } catch (\Throwable $e) {
            return $this->errorResponse('An unexpected error occurred. ERR: '. $e->getMessage(), 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|uuid',
            ]);
            $validatedData = $validator->validated();
            $result = $this->crawlService->getById($validatedData['id']);

            return $this->successResponse($result->toArray());
        } catch (ValidationException $e) {
            return $this->errorResponse('A validation excepion. ERR: ' . $e->getMessage(), 422);
        } catch (\Throwable $e) {
            return $this->errorResponse('An unexpected error occurred. ERR: '. $e->getMessage(), 500);
        }
    }

    public function update(string $id): JsonResponse
    {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|uuid',
            ]);
            $validatedData = $validator->validated();
            $result = $this->crawlService->updateMeta($validatedData['id']);

            return $this->successResponse($result->toArray());
        } catch (ValidationException $e) {
            return $this->errorResponse('A validation excepion. ERR: ' . $e->getMessage(), 422);
        } catch (\Throwable $e) {
            return $this->errorResponse('An unexpected error occurred. ERR: '. $e->getMessage(), 500);
        }
    }

    public function destroy(String $id): JsonResponse
    {   
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|uuid',
            ]);
            $validatedData = $validator->validated();
            $result = $this->crawlService->deleteById($validatedData['id']);

            return $this->successResponse(['deleted' => $result]);
        } catch (ValidationException $e) {
            return $this->errorResponse('A validation excepion. ERR: ' . $e->getMessage(), 422);
        } catch (\Throwable $e) {
            return $this->errorResponse('An unexpected error occurred. ERR: '. $e->getMessage(), 500);
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
