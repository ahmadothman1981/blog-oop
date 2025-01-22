<?php
namespace App\Models;

use core\App;
use Core\Model;

class Post extends Model
{
    protected static $table = 'posts';
    public $id;
    public $title;
    public $content;    
    public $created_at;
    public $user_id;
    public $views;

    public static function getRecent(int $limit)
    {
        /**@var Core\Database $db */
        
        $db = App::get('database');
     return  $db->fetchAll('SELECT * FROM ' . static::$table . ' ORDER BY created_at DESC LIMIT ?', [$limit] , static::class);

    }
}