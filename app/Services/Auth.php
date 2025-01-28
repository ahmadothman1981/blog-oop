<?php
namespace App\Services;

use App\Models\User;

class Auth
{
    protected static $user = null;
    public static function attempt(string $email , string $password):bool
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
    public static function user():?User
    {
        
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if(static::$user === null)
        {
            $userId = $_SESSION['user_id'] ?? null;
            static::$user = $userId ? User::find($userId) : null;
        }
        return static::$user;
    }

    public static function logout():void
    {
        session_destroy();
        static::$user = null;
    }
}