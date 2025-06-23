<?php

declare(strict_types=1);

namespace App\Infrastructure;

abstract class Database
{ 
    public static function connect(): \PDO
    {
        try {
            $env = parse_ini_file(__DIR__ . '/../../.env');

            $db = new \PDO(dsn: 'sqlite:' . __DIR__ . '/../../' . $env['SQLITE_DB']);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $db;
        } catch (\PDOException $e) {
            throw new \PDOException("Error executing query: " . $e->getMessage());
        }
    }

 
    public static function select(string $sql): array
    {
        try{
            $pdo = self::connect();
            $query = $pdo->prepare($sql);
            $query->execute();
            $data = $query->fetchAll(\PDO::FETCH_ASSOC);
            
            // Free the memory
            $query = null; 
            $pdo = null;	
            
            return $data;
        }
        catch(\PDOException $e) {
            throw new \Exception("Error executing select query: " . $e->getMessage());
        }
    }
 
    public static function insert(string $sql): int
    {
        try{
            $pdo = self::connect();
            $query = $pdo->prepare($sql);
            $query->execute();
            $id = $pdo->lastInsertId();
            
            // Free the memory
            $query = null; 
            $pdo = null;	
            
            return (int) $id;
        }
        catch(\PDOException $e) {
            throw new \Exception("Error executing insert query: " . $e->getMessage());
        }
    }
 
    public static function query(string $sql): void
    {
        try {
            $pdo = self::connect();
            $pdo->exec($sql);
            
            // Free the memory
            $pdo = null;
        }
        catch(\PDOException $e) {
            throw new \Exception("Error executing query: " . $e->getMessage());
        }
    }
}