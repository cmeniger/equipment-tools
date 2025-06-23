<?php 

declare(strict_types=1);

namespace App\Application\Ressource;

use App\Domain\EntityInterface;
use App\Domain\EquipmentType;

final readonly class EquipmentTypeRessource implements RessourceInterface
{
    public function __construct(
        private EquipmentType $entity,
    ) {

    }

    public function toArray(): array
    {
        return [
            'id' => $this->entity->getId(),
            'name' => $this->entity->getName(),
            'description' => $this->entity->getDescription(),
        ];
    }

    public static function fromEntity(EntityInterface $entity): self
    {
        return new self(entity: $entity);
    }
}