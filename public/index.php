<?php 

declare(strict_types=1);

require '../bin/autoload.php';

use App\Application\Controller\Equipment\GetEquipmentController;
use App\Application\Controller\Equipment\GetEquipmentsController;
use App\Application\Controller\HealthController;
use App\Infrastructure\Response;
use App\Infrastructure\Routing\Router;

try {
    $router = new Router(url: $_SERVER['REQUEST_URI']);
    
    $router->get(path: '/api/health', controller: HealthController::class, name: 'api:health');
    $router->get(path: '/api/equipments', controller: GetEquipmentsController::class, name: 'api:equipments:list');
    $router->get(path: '/api/equipments/:id', controller: GetEquipmentController::class, name: 'api:equipments:item');
    
    $response = $router->run();
} catch (\Exception $e) {
    $response = Response::JsonResponse(content: ['error' => $e->getMessage()], status: $e->getCode());
} 

$response->send();