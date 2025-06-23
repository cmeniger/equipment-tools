<?php 

declare(strict_types=1);

namespace App\Domain;

use DateTime;

final readonly class LocalisationHistory implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?DateTime $date = null,
        private ?Equipment $equipment = null,
        private ?Localisation $localisation = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            date: isset($data['date']) ? new DateTime(datetime: $data['date']) : null,
            equipment: isset($data['equipment']) ? Equipment::buildFromArray(data: $data['equipment']) : null,
            localisation: isset($data['localisation']) ? Localisation::buildFromArray(data: $data['localisation']) : null,
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

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }
}