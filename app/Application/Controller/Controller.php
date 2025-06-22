<?php 

declare(strict_types=1);

namespace App\Application\Controller;

abstract class Controller
{
    protected array $queryIds = [];
    protected array $queryParameters = [];

    public function __construct(array $queryIds = [], array $queryParameters = [])
    {
        $this->queryIds = $queryIds;
        $this->queryParameters = $queryParameters;
    }

    protected function getId(string $name, mixed $default = null): mixed
    {
        return $this->queryIds[$name] ?? $default;
    }

    protected function getParameter(string $name, mixed $default = null): mixed
    {
        return $this->queryParameters[$name] ?? $default;
    }
}