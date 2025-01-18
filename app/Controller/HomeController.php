<?php 
namespace App\Controller;


use Core\View;
class HomeController
{
    public function index():string
    {
        return View::render('home/index' ,
        data:['message' => 'Hello World'],
    layout:'layouts/main');
    }

}