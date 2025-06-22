<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum State: string
{
    case VALID = '1';
    case WARNING = '2';
    case CRITICAL = '3';
}