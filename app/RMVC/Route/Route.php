<?php

namespace App\RMVC\Route;

class Route
{

    private static array $routersGet = [];

    private static array $routersPost = [];

    /**
     * @return array
     */
    public static function getRoutersGet(): array
    {
        return self::$routersGet;
    }

    public static function getRoutersPost(): array
    {
        return self::$routersPost;
    }

    public static function get(string $route, array $controller): RouteConfiguration
    {

        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        self::$routersGet[] = $routeConfiguration;
        return $routeConfiguration;
        
    }

    public static function post(string $route, array $controller): RouteConfiguration
    {

        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        self::$routersPost[] = $routeConfiguration;
        return $routeConfiguration;

    }

    public static function redirect($url)
    {
        header('Location: '.$url);
    }

}