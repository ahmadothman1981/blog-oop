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
       //create variable for current  page pagination number
       $page = $_GET['page'] ?? 1;
       //create variable for how many items in single page
       $limit = 1;

        $posts = Post::getRecent($limit,$page, $search);
        $total = Post::count($search);
      
        return View::render('post/index' ,
         data:[
        'posts' => $posts,
         'search' => $search,
         'currentPage' => $page,
         'totalPages' => ceil($total/$limit)
        ],
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