<?php 

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Enum\State;
use DateTime;

final readonly class Equipment
{
    /** @var array<InterventionHistory> */
    private array $interventions = [];
    
    /** @var array<LocalisationHistory> */
    private array $localisations = [];

    public function __construct(
        private ?int $id = null,
        private ?DateTime $purchaseDate = null,
        private ?DateTime $commissioningDate = null,
        private ?DateTime $maintenanceDate = null,
        private ?Localisation $localisation = null,
        private ?EquipementType $type = null,
        private ?State $state = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        $self = new self();
        $self->id = $data['id'] ?? null;
        $self->purchaseDate = $data['purchaseDate'] ? new DateTime(datetime: $data['purchaseDate']) : null;
        $self->commissioningDate = $data['commissioningDate'] ? new DateTime(datetime: $data['commissioningDate']) : null;
        $self->maintenanceDate = $data['maintenanceDate'] ? new DateTime(datetime: $data['maintenanceDate']) : null;
        $self->type = $data['type'] ? EquipementType::buildFromArray(data: $data['type']) : null;
        $self->state = State::tryFrom(value: $data['state']);

        return $self;
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

    public function getType(): ?EquipementType
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