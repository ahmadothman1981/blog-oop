<?php
namespace App\Controller;

use Core\View;
use Core\Router;
use App\Services\Auth;
use App\Services\CSRF;

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
        if(!CSRF::verify())
        {
            Router::pageExpired();
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? (bool)$_POST['remember'] : false;
        
        $auth = new Auth();
        if($auth->attempt($email , $password , $remember))
        {
            //CSRF::generateToken(); // Regenerate the token
           // session_regenerate_id(true); // Regenerate session ID
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