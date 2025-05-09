<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected function jsonError(string $message, int $statusCode = 400, string $type = 'error')
    {
        return $this->json(
            ['status' => false, 'message' => $message, 'type' => $type, 'code' => $statusCode],
            $statusCode
        );
    }
}
