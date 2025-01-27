<?php
namespace App\Services;

use App\Models\User;

class Auth
{
    public function attempt(string $email , string $password):bool
    {
        $user = User::findByEmail($email);

        if($user && password_verify($password , $user->password))
        {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user->ID;
            return true;
        }
        return false;
    }
}