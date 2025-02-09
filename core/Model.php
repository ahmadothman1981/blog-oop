<?php
namespace Core;


abstract class Model {
    protected static string $table;
    public $id;

    public static function all(): array {
        $db = App::get('database');
        return  $db->fetchAll("SELECT * FROM " . static::$table , [] , static::class);
            
       
    }

    public static function find(mixed $id): ?static  {
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
    public function save(): static
    {
        $db = App::get('database');
        $data = get_object_vars($this);
        if(!isset($this->id))
        {
            unset($data['id']);
            return static::create($data);
        }
        unset($data['id']);
        //bring keys of the data  --> ['name', 'email', 'password']
        $setParts = array_map(fn($column)=> "$column = ?", array_keys($data));
        $sql = "UPDATE " . static::$table . " SET " . implode(', ', $setParts) . " WHERE id = ?";

        $params = array_values($data);
        $params[] = $this->id;
        $db->query($sql, $params);
        return $this;
    }
    public function delete()
    {
        if(!isset($this->id))
        {
            return;
        }

        $db = App::get('database');
       $sql = "DELETE FROM " . static::$table . " WHERE id = ?"; 
       $db->query($sql, [$this->id]);

    }

    public static function getRecent(?int $limit=null ,?int $page = null)
    {
        /**@var Core\Database $db */
        
        $db = App::get('database');

        $query = 'SELECT * FROM ' . static::$table ;
        $params = [];
        $query .= ' ORDER BY created_at DESC';
        if($limit !== null)
        {
            $query .= ' LIMIT ?';
            $params[] = $limit;
        }
        //offset calculation
        if($page !== null && $limit !== null) 
        {
            $offset = ($page - 1) * $limit;
            //add offset parameter to query
            $query .= ' OFFSET ?';
            // add offset parameter to params
            $params[] = $offset;
        }
        return $db->fetchAll($query , $params , static::class);
     

    }
    public static function count( ):int
    {
        /**@var Core\Database $db */
        
        $db = App::get('database');

        $query = 'SELECT COUNT(*) FROM ' . static::$table ;
       
        return (int) $db->query($query , [] , static::class)->fetchColumn();
    }
}
