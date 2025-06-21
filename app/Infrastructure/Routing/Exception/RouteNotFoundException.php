<?php

declare(strict_types=1);

namespace App\Infrastructure\Routing\Exception;

use Exception;

class RouteNotFoundException extends Exception
{
    public function __construct()
    {
        $this->code = 404;

        parent::__construct('Route not found.');
    }
}