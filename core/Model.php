<?php
namespace Core;

use PDO;

abstract class Model {
    protected static $table;

    public static function all(): array {
        $db = App::get('database');
        return  $db->fetchAll("SELECT * FROM " . static::$table , [] , static::class);
            
       
    }

    public static function find(mixed $id): static | null {
        $db = App::get('database');
        error_log("Finding ID: " . $id);
         return  $db->fetch("SELECT * FROM " . static::$table . " WHERE id = ?", [$id], static::class);
  
    }

    public static function create(array $data): static {
        $db = App::get('database');
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        
        error_log("Executing SQL: " . $sql);
        error_log("With Params: " . json_encode(array_values($data)));
        
        $db->query($sql, array_values($data));
        
        $lastInsertId = $db->lastInsertId();
        error_log('Last Insert ID: ' . $lastInsertId);
        
        $newRecord = static::find($lastInsertId);
        error_log("New Record: " . json_encode($newRecord));
        return $newRecord;
    }

   
}
