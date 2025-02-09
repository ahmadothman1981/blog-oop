<?php
namespace App\Controller;

use Core\Router;
use App\Models\Comment;
use App\Services\Auth;

class CommentController 
{
    public function store($id)
    {
       
       $user = Auth::user();
        $content = $_POST['content'];
        Comment::create([
            'content' => $content,
            'user_id' => $user->id,
            'post_id' => $id
        ]);
      return  Router::redirect("/posts/$id#comments");
    }
}