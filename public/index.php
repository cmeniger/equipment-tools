<?php 

declare(strict_types=1);

require '../bin/autoload.php';

use App\Application\Controller\HealthController;
use App\Infrastructure\Response;
use App\Infrastructure\Routing\Exception\RouteNotFoundException;
use App\Infrastructure\Routing\Router;

try {
    $router = new Router(url: $_SERVER['REQUEST_URI']);
    $router->get(path: '/api/health', controller: HealthController::class, name: 'api:health');
    $response = $router->run();
} catch (RouteNotFoundException $e) {
    $response = Response::JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
} catch (\Exception $e) {
    $response = Response::JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
} 

$response->send();