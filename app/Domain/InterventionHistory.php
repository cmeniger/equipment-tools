<?php 

declare(strict_types=1);

namespace App\Domain;

use DateTime;

final readonly class InterventionHistory implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?DateTime $date = null,
        private ?string $description = null,
        private ?DateTime $maintenanceDate = null,
        private ?string $maintenanceText = null,
        private ?Equipment $equipment = null,
        private ?InterventionType $type = null,
        private ?User $owner = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            date: isset($data['date']) ? new DateTime(datetime: $data['date']) : null,
            description: $data['description'] ?? null,
            maintenanceDate: isset($data['maintenanceDate']) ? new DateTime(datetime: $data['maintenanceDate']) : null,
            maintenanceText: $data['maintenanceText'] ?? null,
            equipment: isset($data['equipment']) ? Equipment::buildFromArray(data: $data['equipment']) : null,
            type: isset($data['type']) ? InterventionType::buildFromArray(data: $data['type']) : null,
            owner: isset($data['owner']) ? User::buildFromArray(data: $data['owner']) : null,


        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getMaintenanceDate(): ?DateTime
    {
        return $this->maintenanceDate;
    }

    public function getMaintenanceText(): ?string
    {
        return $this->maintenanceText;
    }

    public function getType(): ?InterventionType
    {
        return $this->type;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }


    public function isInProgress(): bool
    {
        return $this->maintenanceDate ? false : true;
    }
}