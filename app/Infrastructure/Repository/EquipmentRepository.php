<?php 

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Equipment;
use App\Infrastructure\Database;

final readonly class EquipmentRepository
{
    /**
     * @return Equipment[]
     */
    public function getFiltered(array $filters = [], ?array $sort = null): array
    {
        $query = '
            SELECT eq.*, et.name as et__name, et.description as et__description, lo.name as lo__name, lo.description as lo__description 
            FROM `equipments` AS eq
            LEFT JOIN `equipment_types` AS et on et.id = eq.equipment_type_id
            LEFT JOIN `localisations` AS lo on lo.id = eq.localisation_id
        ';

        // Filters
        $queryFilters = '';
        if ($filters['state']) {
            $queryFilters .= ( $queryFilters ? ' AND ' : '') . 'eq.state=' . $filters['state'];
        }
        if ($filters['localisation']) {
            $queryFilters .= ( $queryFilters ? ' AND ' : '') . 'lo.id=' . $filters['localisation'];
        }
        if ($filters['type']) {
            $queryFilters .= ( $queryFilters ? ' AND ' : '') . 'et.id=' . $filters['type'];
        }
        $query .= $queryFilters ? ' WHERE ' . $queryFilters : '';

        // Sort
        if ($sort[0] === 'localisation') {
            $query .= ' ORDER BY lo.name ' . $sort[1];
        } elseif ($sort[0] === 'type') {
            $query .= ' ORDER BY et.name ' . $sort[1];
        } elseif ($sort[0]) {
            $query .= ' ORDER BY eq.' . $sort[0] . ' ' . $sort[1];
        }

        // Query
        $rows = Database::select(sql: $query);
        $items = [];
        
        foreach ($rows as $row) {
            $items[] = Equipment::buildFromArray(data: [
                'id' => $row['id'],
                'purchaseDate' => $row['purchase_date'],
                'commissioningDate' => $row['commissioning_date'],
                'maintenanceDate' => $row['maintenance_date'],
                'localisation' => ['id' => $row['localisation_id'], 'name' => $row['lo__name'], 'description' => $row['lo__description']],
                'type' => ['id' => $row['equipment_type_id'], 'name' => $row['et__name'], 'description' => $row['et__description']],
                'state' => $row['state'],
            ]);
        }

        return $items;
    }
}