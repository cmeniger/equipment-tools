<?php 

declare(strict_types=1);

namespace App\Application\Controller\Equipment;

use App\Application\Controller\Controller;
use App\Application\Ressource\EquipmentListRessource;
use App\Application\Ressource\PaginatedRessource;
use App\Infrastructure\Repository\EquipmentRepository;
use App\Infrastructure\Response;

final class GetEquipmentsController extends Controller
{
    private EquipmentRepository $repository;

    public function __construct($queryIds, $queryParameters, $route)
    {
        $this->repository = new EquipmentRepository();
        parent::__construct(queryIds: $queryIds, queryParameters: $queryParameters, route: $route);
    }
    
    public function __invoke(): Response
    {
        $filters = [
            'state' => $this->getParameter(name: 'state'),
            'type' => $this->getParameter(name: 'type'),
            'localisation' => $this->getParameter(name: 'localisation'),
        ];
        $sort = explode(separator: ',', string: $this->getParameter(name: 'sort', default: ''));

        $ressource = new PaginatedRessource(
            items: array_map(
                callback: fn($item): EquipmentListRessource => EquipmentListRessource::fromEntity(entity: $item), 
                array: $this->repository->getFiltered(filters: $filters, sort: $sort)
            ),
            page: (int) $this->getParameter(name: 'page', default: 1),
            perPage: (int) $this->getParameter(name: 'perPage', default: 20),
            route: $this->getUrl(params: [], withHost: true, withParams: true),
        );

        return Response::JsonResponse(content: $ressource->toArray());
    }
}