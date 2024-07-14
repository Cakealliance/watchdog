<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Metrics\PrometheusService;
use Illuminate\Http\JsonResponse;

class PrometheusController extends Controller
{
    public function __construct(private readonly PrometheusService $service)
    {}

    public function metrics(): string
    {
        return $this->service->metrics();
    }

    public function createTestOrder(): JsonResponse
    {
        $this->service->createTestOrder();

        return new JsonResponse("OK");
    }
}
