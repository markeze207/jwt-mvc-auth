<?php

namespace App\Http\Core;


// Показ сообщений об ошибках
error_reporting(E_ALL);

// Установим часовой пояс по умолчанию
date_default_timezone_set("Europe/Moscow");


class ConfigJWT
{

    public $key;
    public $iss;
    public $aud;
    public $iat;
    public $nbf;

    /**
     * @param string $key
     * @param string $iss
     * @param string $aud
     * @param int $iat
     * @param int $nbf
     */
    public function __construct($key, $iss, $aud, $iat, $nbf)
    {
        $this->key = $key;
        $this->iss = $iss;
        $this->aud = $aud;
        $this->iat = $iat;
        $this->nbf = $nbf;
    }

}