<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct()
    {
        $this->code = 404;

        parent::__construct('Ressource not found.');
    }
}