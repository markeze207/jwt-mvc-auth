<?php

namespace App\Http\Models;

use App\Http\Core\configJWT;
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
}