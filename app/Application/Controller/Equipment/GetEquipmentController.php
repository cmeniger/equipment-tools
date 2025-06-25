<?php 

declare(strict_types=1);

namespace App\Application\Controller\Equipment;

use App\Application\Controller\Controller;
use App\Application\Ressource\EquipmentRessource;
use App\Domain\Exception\NotFoundException;
use App\Infrastructure\Repository\EquipmentRepository;
use App\Infrastructure\Response;

final class GetEquipmentController extends Controller
{
   private EquipmentRepository $repository;

    public function __construct($queryIds, $queryParameters, $route)
    {
        $this->repository = new EquipmentRepository();
        parent::__construct(queryIds: $queryIds, queryParameters: $queryParameters, route: $route);
    }
    
    public function __invoke(): Response
    {
        $equipment = $this->repository->findById(id: (int) $this->getId());

        if (!$equipment) {
            throw new NotFoundException();
        }

        return Response::JsonResponse(content: EquipmentRessource::fromEntity(entity: $equipment)->toArray());
    }
}