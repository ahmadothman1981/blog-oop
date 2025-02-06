<?php

namespace App\Models;

use core\App;
use Core\Model;

class RememberToken extends Model
{
    protected static string $table = 'remember_tokens';
    public const TOKEN_LIFETIME = 30 * 24 * 60 * 60;

    public $id;
    public int $user_id;
    public string $token;
    public string $created_at;
    public string $expired_at;

    public function rotate(): static
    {
        $this->token = static::generateToken();
        $this->expired_at = static::getExpiryDate();

        if (!$this->save()) {
            throw new \Exception("Failed to save rotated remember token");
        }

        return $this;
    }

    public static function findValid(string $token): ?static
    {
        $db = App::get('database');
        $currentTime = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM " . static::$table . " WHERE token = ? AND expired_at > ? LIMIT 1";
        $result = $db->fetch($sql, [$token, $currentTime], static::class);
        return $result ? $result : null;
    }

    private static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    private static function getExpiryDate(): string
    {
        return date('Y-m-d H:i:s', time() + static::TOKEN_LIFETIME);
    }

    public static function createForUser(int $userId): static
    {
        $data = [
            'user_id' => $userId,
            'token' => static::generateToken(),
            'expired_at' => static::getExpiryDate(),
        ];

        $result = static::create($data);

        if (!$result) {
            throw new \Exception("Failed to create remember token for user ID {$userId}");
        }

        return $result;
    }
}