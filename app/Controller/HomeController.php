<?php 
namespace App\Controller;

use App\Models\Post;
use Core\View;



class HomeController
{
    public function index():string
    {
       $posts = Post::getRecent(5);
      
        return View::render('home/index' ,
        data:['posts' => $posts],
    layout:'layouts/main');
    }

}