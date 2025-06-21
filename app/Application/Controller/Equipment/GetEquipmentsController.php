<?php 

declare(strict_types=1);

namespace App\Application\Controller\Equipment;

use App\Infrastructure\Response;

final class GetEquipmentsController
{
    public function __invoke(): Response
    {
        return Response::JsonResponse(content: ['item' => 'test']);
    }
}