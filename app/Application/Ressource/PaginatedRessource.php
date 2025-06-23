<?php 

declare(strict_types=1);

namespace App\Application\Ressource;

use App\Domain\EntityInterface;

final readonly class PaginatedRessource implements RessourceInterface
{
    public function __construct(
        private array $items,
        private int $page,
        private int $perPage,
        private string $route
    ) {

    }

    public function toArray(): array
    {
        $total = count(value: $this->items);
        $lastPage = ceil($total / $this->perPage);
        $items = array_slice($this->items, $this->page - 1, $this->perPage);
        $link = '%s&page=%d';

        return [
            'items' => array_map(callback: fn($item): array => $item->toArray(), array: $items),
            'meta' => [
                'currentPage' => $this->page,
                'lastPage'=> $lastPage > 0 ? $lastPage : $this->page,
                'perPage'=> $this->perPage,
                'total' => $total,
            ],
            'links' => [
                'first' => sprintf($link, $this->route, 1),
                'last' => $lastPage > 1 ? sprintf($link, $this->route, $lastPage) : null,
                'prev' => $this->page > 1 ? sprintf($link, $this->route, $this->page - 1) : null,
                'next' => $this->page < $lastPage ? sprintf($link, $this->route, $this->page + 1) : null,
            ],
        ];
    }

    public static function fromEntity(EntityInterface $entity): self
    {
        return new self(items: [], page: 0, perPage: 0, route: '');
    }
}