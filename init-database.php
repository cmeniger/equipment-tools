<?php

declare(strict_types=1);

require_once 'app/Infrastructure/Database.php';

Database::query(query: "
    DROP TABLE IF EXISTS localisations;
    CREATE TABLE localisations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(64),
        description TEXT
    );
");

Database::query(query: "
    DROP TABLE IF EXISTS equipement_types;
    CREATE TABLE equipement_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(64),
        description TEXT
    );
");

Database::query(query: "
    DROP TABLE IF EXISTS intervention_types;
    CREATE TABLE intervention_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(64),
        equipment_type_id INT,
        state INT
    );
");

Database::query(query: "
    DROP TABLE IF EXISTS users;
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(64),
        last_name VARCHAR(64)
    );
");

Database::query(query: "
    DROP TABLE IF EXISTS equipments;
    CREATE TABLE equipments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        purchase_date DATETIME,
        commissioning_date DATETIME,
        maintenance_date DATETIME,
        localisation_id INT,
        equipment_type_id INT,
        state INT
    );
");

Database::query(query: "
    DROP TABLE IF EXISTS localisation_histories;
    CREATE TABLE localisation_histories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date DATETIME,
        localisation_id INT,
        equipment_id INT
    );
");

Database::query(query: "
    DROP TABLE IF EXISTS intervention_histories;
    CREATE TABLE intervention_histories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date DATETIME,
        description TEXT,
        equipment_id INT,
        intervention_type_id INT,
        user_id INT,
        maintenance_date DATETIME,
        maintenance_text TEXT
    );
");
