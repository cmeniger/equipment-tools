<?php 

declare(strict_types=1);

namespace App\Application\Ressource;

use App\Domain\EntityInterface;
use App\Domain\Equipment;

final readonly class EquipmentListRessource implements RessourceInterface
{
    public function __construct(
        private Equipment $entity,
    ) {

    }

    public function toArray(): array
    {
        return [
            'id' => $this->entity->getId(),
            'state' => $this->entity->getState()?->value,     
            'commissioningDate' => $this->entity->getCommissioningDate()?->format('Y-m-d H:i:s'),
            'interventionCount' => $this->entity->countInterventions(),
            'type' => $this->entity->getType() ? EquipmentTypeRessource::fromEntity($this->entity->getType())->toArray() : null,
            'localisation' => $this->entity->getLocalisation() ? LocalisationRessource::fromEntity($this->entity->getLocalisation())->toArray() : null,
        ];
    }

    public static function fromEntity(EntityInterface $entity): self
    {
        return new self(entity: $entity);
    }
}