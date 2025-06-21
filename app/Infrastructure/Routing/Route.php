<?php

declare(strict_types=1);

namespace App\Infrastructure\Routing;

final class Route {
    private string $path;
    private string $controller;
    private array $matches = [];
    private array $params = [];

    public function __construct(string $path, string $controller)
    {
        $this->path = trim(string: $path, characters: '/');
        $this->controller = $controller;
    }

    public function match($url): bool
    {
        $url = trim(string: $url, characters: '/');
        $path = preg_replace_callback(pattern: '#:([\w]+)#', callback: [$this, 'paramMatch'], subject: $this->path);
        $regex = "#^$path$#i";
        if(!preg_match(pattern: $regex, subject: $url, matches: $matches)){
            return false;
        }
        array_shift(array: $matches);
        $this->matches = $matches;
        
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
        $controller = new $this->controller;
        
        return $controller($this->matches);
    }
}
