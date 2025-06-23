<?php 

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Enum\State;
use DateTime;

final class Equipment implements EntityInterface
{
    /** @var array<InterventionHistory> */
    private array $interventions = [];
    
    /** @var array<LocalisationHistory> */
    private array $localisations = [];

    public function __construct(
        private readonly ?int $id = null,
        private readonly ?DateTime $purchaseDate = null,
        private readonly ?DateTime $commissioningDate = null,
        private readonly ?DateTime $maintenanceDate = null,
        private readonly ?Localisation $localisation = null,
        private readonly ?EquipmentType $type = null,
        private readonly ?State $state = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            purchaseDate: isset($data['purchaseDate']) ? new DateTime(datetime: $data['purchaseDate']) : null,
            commissioningDate: isset($data['commissioningDate']) ? new DateTime(datetime: $data['commissioningDate']) : null,
            maintenanceDate: isset($data['maintenanceDate']) ? new DateTime(datetime: $data['maintenanceDate']) : null,
            localisation: isset($data['localisation']) ? Localisation::buildFromArray(data: $data['localisation']) : null,
            type: isset($data['type']) ? EquipmentType::buildFromArray(data: $data['type']) : null,
            state: State::tryFrom(value: (string) $data['state'] ?? ''),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchaseDate(): ?DateTime
    {
        return $this->purchaseDate;
    }

    public function getCommissioningDate(): ?DateTime
    {
        return $this->commissioningDate;
    }

    public function getMaintenanceDate(): ?DateTime
    {
        return $this->maintenanceDate;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function getType(): ?EquipmentType
    {
        return $this->type;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    // Intervention histories

    public function addIntervention(InterventionHistory $intervention): void
    {
        foreach ($this->interventions as $in) {
            if ($in->getId() === $intervention->getId()) {
                return;
            }
        }

        $this->interventions[] = $intervention;
    }

    public function getInterventions(): array
    {
        return $this->interventions;
    }

    public function countInterventions(): int
    {
        return count(value: $this->interventions);
    }

    // Localisation histories

    public function addLocalisation(LocalisationHistory $localisation): void
    {
        foreach ($this->localisations as $loc) {
            if ($loc->getId() === $localisation->getId()) {
                return;
            }
        }

        $this->localisations[] = $localisation;
    }

    public function getLocalisations(): array
    {
        return $this->localisations;
    }

    public function countLocalisations(): int
    {
        return count(value: $this->localisations);
    }
}