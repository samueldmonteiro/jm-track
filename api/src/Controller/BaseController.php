<?php

namespace App\Controller;

use App\Controller\Rules\RuleValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    protected function jsonError(?string $message = null, int $statusCode = 400, mixed $data = null, string $type = 'error')
    {
        return $this->json(
            [
                'status' => false,
                'message' => $message,
                'data' => $data,
                'type' => $type,
                'code' => $statusCode
            ],
            $statusCode ? $statusCode : 500
        );
    }

    protected function handleRequest(
        RuleValidator $validator,
        object $rules,
        callable $useCaseCallback,
        array $context = [],
        ?callable $formatResponse = null
    ): JsonResponse {
        $errors = $validator->validate($rules);

        if ($errors) {
            return $this->jsonError(data: $errors);
        }

        try {
            $result = $useCaseCallback($rules);
            $response = $formatResponse ? $formatResponse($result) : $result;

            return $this->json($response, context: $context);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode());
        }
    }
}
