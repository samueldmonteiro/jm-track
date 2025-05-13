<?php

namespace App\Controller;

use App\UseCase\TrafficSource\FindAll\FindAllTrafficSource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class TrafficSourceController extends BaseController
{
    public function __construct(
        private FindAllTrafficSource $findAllTrafficSource,
    ) {}

    public function findAll(Request $request): JsonResponse
    {
        return $this->jsonSuccess(
            $this->findAllTrafficSource->execute()->toArray(),
            context: ['groups'=> ['tSource:read']]
        );
    }
}
