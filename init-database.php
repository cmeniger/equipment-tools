<?php

declare(strict_types=1);

require_once 'app/Domain/Enum/State.php';
require_once 'app/Infrastructure/Database.php';

use App\Domain\Enum\State;
use App\Infrastructure\Database;

Database::query(sql: "
    DROP TABLE IF EXISTS localisations;
    CREATE TABLE localisations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        description TEXT
    );
");

Database::query(sql: "
    DROP TABLE IF EXISTS equipment_types;
    CREATE TABLE equipment_types (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        description TEXT
    );
");

Database::query(sql: "
    DROP TABLE IF EXISTS intervention_types;
    CREATE TABLE intervention_types (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        equipment_type_id INTEGER,
        state INTEGER
    );
");

Database::query(sql: "
    DROP TABLE IF EXISTS users;
    CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name TEXT,
        last_name TEXT
    );
");

Database::query(sql: "
    DROP TABLE IF EXISTS equipments;
    CREATE TABLE equipments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        purchase_date DATETIME,
        commissioning_date DATETIME,
        maintenance_date DATETIME,
        localisation_id INTEGER,
        equipment_type_id INTEGER,
        state INTEGER
    );
");

Database::query(sql: "
    DROP TABLE IF EXISTS localisation_histories;
    CREATE TABLE localisation_histories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        date DATETIME,
        localisation_id INTEGER,
        equipment_id INTEGER
    );
");

Database::query(sql: "
    DROP TABLE IF EXISTS intervention_histories;
    CREATE TABLE intervention_histories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        date DATETIME,
        description TEXT,
        equipment_id INTEGER,
        intervention_type_id INTEGER,
        user_id INTEGER,
        maintenance_date DATETIME,
        maintenance_text TEXT
    );
");

$localisations = [
    'C101' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('C 101', 'Chambre 101 au 1er étage')"),
    'C102' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('C 102', 'Chambre 102 au 1er étage')"),
    'C103' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('C 103', 'Chambre 103 au 1er étage')"),
    'C201' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('C 201', 'Chambre 101 au 2eme étage')"),
    'C202' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('C 202', 'Chambre 102 au 1er étage')"),
    'C203' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('C 203', 'Chambre 103 au 1er étage')"),
    'S001' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('S 001', 'Salle de soin 1 au 1er étage')"),
    'S002' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('S 002', 'Salle de soin 2 au 2ème étage')"),
    'RESERVE' => Database::insert(sql: "INSERT INTO localisations(name, description) VALUES ('RESERVE', 'La réserve au sous sol')"),
];

$equipmentTypes = [
    'LIT' => Database::insert(sql: "INSERT INTO equipment_types(name, description) VALUES ('Lit', 'Lit médicalisé')"),
    'OX5' => Database::insert(sql: "INSERT INTO equipment_types(name, description) VALUES ('Oxygen 5', 'Bouteille d’oxygène 5 litres')"),
    'OX10' => Database::insert(sql: "INSERT INTO equipment_types(name, description) VALUES ('Oxygen 10', 'Bouteille d’oxygène 10 litres')"),
    'DAE' => Database::insert(sql: "INSERT INTO equipment_types(name, description) VALUES ('DAE', 'Défibrillateur externe automatisé')"),
];

$interventionTypes = [
    'LIT-1' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Motorisation', " . $equipmentTypes['LIT'] . "," . State::CRITICAL->value . ")"),
    'LIT-2' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Barrière qui grince', " . $equipmentTypes['LIT'] . "," . State::VALID->value . ")"),
    'DAE' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Batterie faible', " . $equipmentTypes['DAE'] . "," . State::CRITICAL->value . ")"),
    'OXY-5' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Pression', " . $equipmentTypes['OX5'] . "," . State::CRITICAL->value . ")"),
    'OXY-10' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Pression', " . $equipmentTypes['OX10'] . "," . State::CRITICAL->value . ")"),
    'OTHER-1' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Autre', null," . State::VALID->value . ")"),
    'OTHER-2' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Autre', null," . State::WARNING->value . ")"),
    'OTHER-3' => Database::insert(sql: "INSERT INTO intervention_types(name, equipment_type_id, state) VALUES ('Autre', null," . State::CRITICAL->value . ")"),
];

Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['C101'] . ", " . $equipmentTypes['LIT'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['C102'] . ", " . $equipmentTypes['LIT'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/02/15', '2020/02/25', null, " . $localisations['C103'] . ", " . $equipmentTypes['LIT'] . ", " . State::WARNING->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/02/15', '2020/02/25', null, " . $localisations['C201'] . ", " . $equipmentTypes['LIT'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/03/15', '2020/03/25', null, " . $localisations['C202'] . ", " . $equipmentTypes['LIT'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/03/15', '2020/03/25', null, " . $localisations['C203'] . ", " . $equipmentTypes['LIT'] . ", " . State::WARNING->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['C203'] . ", " . $equipmentTypes['LIT'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['S001'] . ", " . $equipmentTypes['LIT'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['S001'] . ", " . $equipmentTypes['OX5'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['S001'] . ", " . $equipmentTypes['DAE'] . ", " . State::WARNING->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['S002'] . ", " . $equipmentTypes['LIT'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['S002'] . ", " . $equipmentTypes['OX10'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['S002'] . ", " . $equipmentTypes['DAE'] . ", " . State::VALID->value . ")");
Database::insert(sql: "INSERT INTO equipments(purchase_date, commissioning_date, maintenance_date, localisation_id, equipment_type_id, state) VALUES ('2020/01/15', '2020/01/25', null, " . $localisations['RESERVE'] . ", " . $equipmentTypes['LIT'] . ", " . State::CRITICAL->value . ")");