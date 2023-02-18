<?php

namespace App\Http\Core;

use PDO;

class Db
{
    public static function getConnection(): PDO
    {
        return new PDO("mysql:host=localhost;dbname=auth", "root", "");
    }
}