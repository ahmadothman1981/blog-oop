<?php
namespace App\Models;

use core\App;
use Core\Model;

class Comment extends Model
{
    protected static $table = 'comments';

    public $id;
    public $post_id;
    public $content;
    public $created_at;
    public $updated_at;
    public $user_id;

    public static function forPost(int $postId): array 
    {
        $db = App::get('database');
      return  $db->fetchAll(
        "SELECT * FROM " . static::$table . " WHERE post_id = ? ORDER BY created_at DESC", [$postId], static::class);
        
    }
}