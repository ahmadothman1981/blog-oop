<?php 
namespace App\Services;

use App\Models\RememberToken;
use App\Models\User;

class RememberMe
{
    private const COOKIE_NAME = 'rememberme';

    public static function createToken(int $userId)
    {
        $token = RememberToken::createForUser($userId)->token;
        static::setCookie($token);
        return $token;
    }
    public static function user(): ?User
    {
        $tokenString = $_COOKIE[static::COOKIE_NAME] ?? null;
        if ($tokenString === null)
         {
             return null;
         }
         $token = RememberToken::findValid($tokenString);
         if(!$token)
         {
             return null;
         }
         $user = User::find($token->user_id);
         if($user)
         {
             static::rotateToken($token);
         }
         return $user;
    }
    public static  function clearToken():void
    {
        $tokenString = $_COOKIE[self::COOKIE_NAME] ?? null;
        if($tokenString)
        {
            $token = RememberToken::findValid($tokenString);
            if($token)
            {
                $token->delete();
            }
            static::removeCookie();
        }
    }
    private static function rotateToken(RememberToken $token)
    {
        $token->rotate();
        static::setCookie($token->token);
    }
    private static function setCookie(string $token):void
    {
        $expiry = time() + RememberToken::TOKEN_LIFETIME;
                setcookie(self::COOKIE_NAME, $token, $expiry, '/' , '', true, true);
    }
    private static function removeCookie():void
    {
        // set cookie time in the past to delete it 
        setcookie(self::COOKIE_NAME, '', time() - 3600, '/' , '', true, true);
    }
}