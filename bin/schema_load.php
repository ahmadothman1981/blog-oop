<?php
use core\App;
require_once __DIR__. '/../bootstrap.php';


$db = App::get('database');

$schemaFile = __DIR__ . '/../database/schema.sql';

$sql = file_get_contents($schemaFile);




    $parts = array_filter(array:explode(separator: ';', string: $sql));
   //var_dump($parts);
    foreach ($parts as $sqlPart) 
    {
        $db->query($sqlPart);
    }
   echo "Schema loaded successfully";
