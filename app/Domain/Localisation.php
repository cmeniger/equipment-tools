<?php 

declare(strict_types=1);

namespace App\Domain;

final readonly class Localisation
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?string $description = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        $self = new self();
        $self->id = $data['id'] ?? null;
        $self->name = $data['name'] ?? null;
        $self->description = $data['description'] ?? null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }
}