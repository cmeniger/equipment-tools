<?php

declare(strict_types=1);

abstract class Database
{
    public static $affected_rows;
 
    public static function connect(): PDO
    {
        try {
            $env = parse_ini_file(__DIR__ . '/../../.env');
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $env['MYSQL_HOST'], $env['MYSQL_DATABASE']);
        
            $pdo = new PDO($dsn, username: $env['MYSQL_USER'], password: $env['MYSQL_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Error executing query: " . $e->getMessage());
        }
    }

 
    public static function select(string $sql): array
    {
        try{
            $pdo = self::connect();
            $query = $pdo->prepare($sql);
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            
            // Free the memory
            $query = null; 
            $pdo = null;	
            
            return $data;
        }
        catch(PDOException $e) {
            throw new Exception("Error executing query: " . $e->getMessage());
        }
    }
 
    public static function insert(string $sql): int
    {
        try{
            $pdo = self::connect();
            $query = $pdo->prepare($sql);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);
            
            // Free the memory
            $query = null; 
            $pdo = null;	
            
            return $data['id'];
        }
        catch(PDOException $e) {
            throw new Exception("Error executing query: " . $e->getMessage());
        }
    }
 
    public static function query(string $query): void
    {
        try {
            $pdo = self::connect();
            $query = $pdo->prepare($query);
            $query->execute();
            
            // Free the memory
            $query = null; 
            $pdo = null;
        }
        catch(PDOException $e) {
            throw new Exception("Error executing query: " . $e->getMessage());
        }
    }
}