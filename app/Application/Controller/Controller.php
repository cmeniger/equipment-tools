<?php 

declare(strict_types=1);

namespace App\Application\Controller;

use App\Infrastructure\Routing\Route;

abstract class Controller
{
    public function __construct(
        protected array $queryIds = [], 
        protected array $queryParameters = [], 
        protected ?Route $route = null,
        )
    {
    }

    protected function getId(string $name, mixed $default = null): mixed
    {
        return $this->queryIds[$name] ?? $default;
    }

    protected function getParameter(string $name, mixed $default = null): mixed
    {
        return $this->queryParameters[$name] ?? $default;
    }

    protected function getUrl(array $params = [], bool $withHost = false, bool $withParams = false): ?string
    {
        return $this->route?->getUrl(params: $params, withHost: $withHost, withParams: $withParams);
    }
}