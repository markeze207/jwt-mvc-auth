<?php

namespace App\Http\Models;

use App\Http\Core\ConfigJWT;
use App\Http\Core\Db;
use App\RMVC\Route\Route;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Auth
{

    public static function checkLogged()
    {

        if(isset($_COOKIE['userId']))
        {
            return true;
        }
        return false;
    }
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE email = ?';

        $result = $db->prepare($sql);
        $result->execute([$email]);

        $user = $result->fetch();

        if ($user && password_verify($password, $user['password']))
        {
            return $user['ID'];
        }
        return false;
    }
    public static function auth($userId): string
    {
        $config = new configJWT('ffffff', 'http://rmvc', 'http://rmvc', 12312312, 123123123);
        $token = array(
            "iss" => $config->iss,
            "aud" => $config->aud,
            "iat" => $config->iat,
            "nbf" => $config->nbf,
            "data" => array(
                "ID" => $userId
            )
        );
        $jwt = JWT::encode($token, $config->key, 'HS256');
        setcookie('jwt',$jwt);
        setcookie('userId',$userId);
        return $jwt;
    }
}