<?php 

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Enum\State;

final readonly class InterventionType implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?EquipmentType $type = null,
        private ?State $state = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            type: isset($data['type']) ? EquipmentType::buildFromArray(data: $data['type']) : null,
            state: State::tryFrom(value: (string) $data['state'] ?? ''),
        );
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