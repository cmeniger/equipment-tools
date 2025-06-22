<?php 

declare(strict_types=1);

namespace App\Domain;

use DateTime;

final readonly class InterventionHistory
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
        $self = new self();
        $self->id = $data['id'] ?? null;
        $self->date = $data['date'] ? new DateTime(datetime: $data['date']) : null;
        $self->description = $data['description'] ?? null;
        $self->maintenanceDate = $data['maintenanceDate'] ? new DateTime(datetime: $data['maintenanceDate']) : null;
        $self->maintenanceText = $data['maintenanceText'] ?? null;
        $self->equipment = $data['equipment'] ? Equipment::buildFromArray(data: $data['equipment']) : null;
        $self->type = $data['type'] ? InterventionType::buildFromArray(data: $data['type']) : null;
        $self->owner = $data['owner'] ? User::buildFromArray(data: $data['owner']) : null;

        return $self;
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