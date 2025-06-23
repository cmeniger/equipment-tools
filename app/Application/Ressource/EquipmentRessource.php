<?php 

declare(strict_types=1);

namespace App\Application\Ressource;

use App\Domain\EntityInterface;
use App\Domain\Equipment;

final readonly class EquipmentRessource implements RessourceInterface
{
    public function __construct(
        private Equipment $entity,
    ) {

    }

    public function toArray(): array
    {
        return [
            'id' => $this->entity->getId(),
            'purchaseDate' => $this->entity->getPurchaseDate()?->format('Y-m-d H:i:s'),
            'commissioningDate' => $this->entity->getCommissioningDate()?->format('Y-m-d H:i:s'),
            'maintenanceDate' => $this->entity->getMaintenanceDate()?->format('Y-m-d H:i:s'),
            'localisation' => $this->entity->getLocalisation() ? LocalisationRessource::fromEntity($this->entity->getLocalisation())->toArray() : null,
            'type' => $this->entity->getType() ? EquipmentTypeRessource::fromEntity($this->entity->getType())->toArray() : null,
            'state' => $this->entity->getState()?->value,     
        ];
    }

    public static function fromEntity(EntityInterface $entity): self
    {
        return new self(entity: $entity);
    }
}