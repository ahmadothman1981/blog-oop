<?php
namespace App\Controller;

use Core\View;
use Core\Router;
use App\Models\Post;
use App\Models\Comment;

class PostController
{
    public function index()
    {
       $search = $_GET['search'] ?? '';
        $posts = Post::getRecent(5, $search);
      
        return View::render('post/index' ,
        data:['posts' => $posts, 'search' => $search],
    layout:'layouts/main');
    }
    public function show($id)
    {
        $posts = Post::find($id);
        if(!$posts)
        {
            Router::notFound();
        }
        $comments = Comment::forPost($id);
        Post::incrementViews($id);
        return View::render(template:'post/show' ,
        data: ['post' => $posts , 'comments' => $comments],
        layout:'layouts/main');
    }

}