<?php 

declare(strict_types=1);

namespace App\Domain;

final readonly class User
{
    public function __construct(
        private ?int $id = null,
        private ?string $firstName = null,
        private ?string $lastName = null,
    ) {

    }

    public static function buildFromArray(array $data): self
    {
        $self = new self();
        $self->id = $data['id'] ?? null;
        $self->firstName = $data['firstName'] ?? null;
        $self->lastName = $data['lastName'] ?? null;

        return $self;
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