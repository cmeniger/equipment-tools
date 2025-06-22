<?php

declare(strict_types=1);

namespace App\Infrastructure\Routing;

use App\Infrastructure\Routing\Exception\RouteNotFoundException;

final class Router {

    private string $url;
    private array $queryParameters = [];
    private array $routes = [];
    private array $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = explode(separator: '?', string: $url)[0];
        $this->queryParameters = $_GET; 
    }

    public function get(string $path, string $controller, string $name, array $params = []): Route
    {
        return $this->add(
            path: $path, 
            controller: $controller, 
            name: $name, 
            method: 'GET',
            params: $params,
        );
    }

    public function post(string $path, string $controller, string $name, array $params = []): Route
    {
        return $this->add(
            path: $path, 
            controller: $controller, 
            name: $name, 
            method: 'POST',
            params: $params,
        );
    }

    private function add(string $path, string $controller, string $name, string $method, array $params = []): Route
    {
        $route = new Route(path: $path, controller: $controller, queryParameters: $this->queryParameters, params: $params);
               
        $this->routes[$method][] = $route;
        $this->namedRoutes[$name] = $route;

        return $route;
    }

    public function run(): mixed
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouteNotFoundException();
        }
        
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)) {
                return $route->call();
            }
        }
        
        throw new RouteNotFoundException();
    }

    public function url($name, $params = []): string
    {
        if(!isset($this->namedRoutes[$name])){
            throw new RouteNotFoundException();
        }
        
        return $this->namedRoutes[$name]->getUrl(params: $params);
    }
}
