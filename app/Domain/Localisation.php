<?php 

declare(strict_types=1);

namespace App\Domain;

final readonly class Localisation implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?string $description = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
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

    public function getDescription(): ?string
    {
        return $this->description;
    }
}