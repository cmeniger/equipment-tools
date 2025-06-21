<?php 

declare(strict_types=1);

namespace App\Application\Controller;

use App\Infrastructure\Response;

final class HealthController
{
    public function __invoke(): Response
    {
        return Response::JsonResponse(content: ['health' => 'ok']);
    }
}