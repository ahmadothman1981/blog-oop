<?php
namespace App\Controller;

use Core\View;
use Core\Router;
use App\Services\Auth;

class AuthController
{
    public function create()
    {
        return View::render(
            template:'auth/create',
            layout:'layouts/main'
        );
    }
    public function store()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? (bool)$_POST['remember'] : false;
        
        $auth = new Auth();
        if($auth->attempt($email , $password , $remember))
        {
            Router::redirect('/'); 
        }

        return View::render(
            template:'auth/create',
            layout:'layouts/main',
            data: ['errors' => 'Invalid credentials']
        );
    }
    public function destroy()
    {
        Auth::logout();
        Router::redirect('/login');
    }
}