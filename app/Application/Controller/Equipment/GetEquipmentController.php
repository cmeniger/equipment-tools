<?php 

declare(strict_types=1);

namespace App\Application\Controller\Equipment;

use App\Application\Controller\Controller;
use App\Infrastructure\Response;

final class GetEquipmentController extends Controller
{
    public function __invoke(): Response
    {
        return Response::JsonResponse(content: ['item' => $this->getId(name: 'id')]);
    }
}