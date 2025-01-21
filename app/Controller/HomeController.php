<?php 
namespace App\Controller;


use Core\View;
use Exception;

class HomeController
{
    public function index():string
    {
        throw new Exception(' web An error occurred');
        return View::render('home/index' ,
        data:['message' => 'Hello World'],
    layout:'layouts/main');
    }

}