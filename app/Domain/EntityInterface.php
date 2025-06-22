<?php

declare(strict_types=1);

namespace App\Domain;

interface EntityInterface
{
    public static function buildFromArray(array $data): self;
}