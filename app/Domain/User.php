<?php 

declare(strict_types=1);

namespace App\Domain;

final readonly class User implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $firstName = null,
        private ?string $lastName = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }
}