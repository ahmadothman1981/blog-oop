<?php
namespace core;

use PDO;

abstract class Model
{
    protected static $table;

    //all method return all instances of the model
    public static function all():array 
    {
        //get the database instance from the container
        $db = App::get('database');
        //query the database to get all records from the table
        $result = $db->query("SELECT * FROM " . static::$table)->fetchAll(PDO::FETCH_ASSOC);
        return array_map([static::class, 'createFromArray'], $result);
    }
    //find method return a single instance of the model
    //or null if no record found
    //find method accept an id as argument and mixed because can be integer or string if id is foreign key
    public static function find(mixed $id): static | null 
    {
        $db = App::get('database');
        $result = $db->query("SELECT * FROM " . static::$table . "WHERE id = ?", [$id])->fetch(PDO::FETCH_ASSOC) ; 
        return $result ? static::createFromArray($result) : null;
    }
    //create method accept an array of data and return a new instance of the model

    public static function create(array $data):static 
    {
        $db = App::get('database');
        //get the columns and values from the data array
        //to be used in the insert query
        $columns = implode(',', array_keys($data));
        $placeholdres = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO " . static::$table . "($columns) VALUES ($placeholdres)";
        $db->query($sql, array_values($data));
        return static::find($db->lastInsertId());
    }

    //helper method to create a new instance of the model from an array of data
    //this method is used by the all and find method to create instances of the model
    //from the result of the database query
    //the job of this helper method  to converting an array result with the datbase record into model object
    //
    protected static function  createFromArray(array $data):static 
    {
        $model = new static();
        foreach ($data as $key => $value) 
        {
            //check if the property exists in the model
            if(property_exists($model, $key))
            {
                $model->$key = $value;
            }
        }
        return $model;
    }
}