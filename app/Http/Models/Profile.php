<?php

namespace App\Http\Models;

use App\Http\Core\configJWT;
use App\Http\Core\Db;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Profile
{

    public static function validateJWT($jwt)
    {
        // Получаем JWT
        $jwt = $jwt ?? "";

        // Если JWT не пуст
        if ($jwt) {

            // Если декодирование выполнено успешно, показать данные пользователя
            try {
                // Декодирование jwt
                $config = new configJWT();
                return JWT::decode($jwt, new Key('ffffff', 'HS256'));
            }

                // Если декодирование не удалось, это означает, что JWT является недействительным
            catch (Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function getName($userId) // Тестовый метод
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE ID = ?';

        $result = $db->prepare($sql);
        $result->execute([$userId]);

        $user = $result->fetch();

        return $user['name'];
    }
}