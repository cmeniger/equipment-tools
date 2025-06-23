<?php 

namespace App\Application\Ressource;

use App\Domain\EntityInterface;

interface RessourceInterface
{
    public function toArray(): array;
    public static function fromEntity(EntityInterface $entity): self;
}