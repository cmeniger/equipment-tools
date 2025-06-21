<?php

declare(strict_types=1);

namespace App\Infrastructure\Routing;

use App\Infrastructure\Routing\Exception\RouteNotFoundException;

final class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get(string $path, string $controller, string $name): Route
    {
        return $this->add(
            path: $path, 
            controller: $controller, 
            name: $name, 
            method: 'GET'
        );
    }

    public function post(string $path, string $controller, string $name): Route
    {
        return $this->add(
            path: $path, 
            controller: $controller, 
            name: $name, 
            method: 'POST'
        );
    }

    private function add(string $path, string $controller, string $name, string $method): Route
    {
        $route = new Route(path: $path, controller: $controller);
               
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

    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new RouteNotFoundException();
        }
        
        return $this->namedRoutes[$name]->getUrl(params: $params);
    }
}
