<?php

declare(strict_types=1);

namespace App\Infrastructure\Routing;

final class Route {
    private string $path;
    private string $controller;
    private array $matches = [];
    private array $params = [];
    private array $queryParameters = [];

    public function __construct(string $path, string $controller, array $queryParameters = [], array $params = [])
    {
        $this->path = trim(string: $path, characters: '/');
        $this->controller = $controller;
        $this->queryParameters = $queryParameters;
        $this->params = $params;
    }

    public function match($url): bool
    {
        $patternParam = '#:([\w]+)#';

        $url = trim(string: $url, characters: '/');
        $path = preg_replace_callback(pattern: $patternParam, callback: [$this, 'paramMatch'], subject: $this->path);
        $regex = "#^$path$#i";
      
        if(!preg_match(pattern: $regex, subject: $url, matches: $matches)){
            return false;
        }

        preg_match_all(pattern: $patternParam, subject: $this->path, matches: $paramNames);

        array_shift(array: $matches);

        foreach ($paramNames[1] as $key => $id) {
            $this->matches[$id] = $matches[$key];
        }

        return true;
    }

    private function paramMatch($match): string
    {
        if(isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        
        return '([^/]+)';
    }

    public function getUrl($params): string
    {
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(search: ":$k", replace: $v, subject: $path);
        }
        
        return $path;
    }

    public function call(): mixed
    {
        $controller = new $this->controller($this->matches, $this->queryParameters);

        return $controller();
    }
}
