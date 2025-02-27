<?php
namespace App\Models;

use core\App;
use Core\Model;

class Post extends Model
{
    protected static string $table = 'posts';
    public $id;
    public $title;
    public $content;    
    public $created_at;
    public $user_id;
    public $views;

    public static function getRecent(?int $limit=null ,?int $page = null, ?string $search=null)
    {
        /**@var Core\Database $db */
        
        $db = App::get('database');

        $query = 'SELECT * FROM ' . static::$table ;
        $params = [];
        if($search !== null)
        {
           $query .= ' WHERE title LIKE ? OR content LIKE ?';
           $params = ["%$search%" , "%$search%"]; 
        }
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
    public static function count( ?string $search=null):int
    {
        /**@var Core\Database $db */
        
        $db = App::get('database');

        $query = 'SELECT COUNT(*) FROM ' . static::$table ;
        $params = [];
        if($search !== null)
        {
           $query .= ' WHERE title LIKE ? OR content LIKE ?';
           $params = ["%$search%" , "%$search%"]; 
        }
        
        return (int) $db->query($query , $params , static::class)->fetchColumn();
    }

    public static function incrementViews($id):void
    {
        $db = App::get('database');
        $db-> query('UPDATE ' . static::$table . ' SET views = views + 1 WHERE id = ?', [$id]);
    }
}