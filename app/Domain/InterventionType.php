<?php 

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Enum\State;

final readonly class InterventionType implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?EquipementType $type = null,
        private ?State $state = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        $self = new self();
        $self->id = $data['id'] ?? null;
        $self->name = $data['name'] ?? null;
        $self->type = $data['type'] ? EquipementType::buildFromArray(data: $data['type']) : null;
        $self->state = State::tryFrom(value: $data['state']);

        return $self;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getType(): ?EquipementType
    {
        return $this->type;
    }

    public function getState(): ?State
    {
        return $this->state;
    }
}