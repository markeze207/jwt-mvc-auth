<?php

namespace App\RMVC\Route;

class RouteDispatcher
{

    private string $requestURI = '/';

    private array $paramMap = [];

    private array $paramRequestMap = [];

    private RouteConfiguration $routeConfiguration;

    /**
     * @param RouteConfiguration $routeConfiguration
     */
    public function __construct(RouteConfiguration $routeConfiguration)
    {
        $this->routeConfiguration = $routeConfiguration;
    }

    public function proccess()
    {

        $this->saveRequestURI();

        $this->setParamMap();

        $this->makeRegexRequest();

        $this->run();

    }

    private function saveRequestURI()
    {
        if($_SERVER['REQUEST_URI'] !== '/')
        {
            $this->requestURI = $this->clean($_SERVER['REQUEST_URI']);
            $this->routeConfiguration->route = $this->clean($this->routeConfiguration->route);
        }

    }
    private function clean($str): string
    {
        return preg_replace('/(^\/)|(\/$)/', '', $str);
    }

    private function setParamMap()
    {
        $routeArray = explode('/', $this->routeConfiguration->route);

        foreach($routeArray as $paramKey => $param)
        {
            if(preg_match('/{.*}/',$param))
            {
                $this->paramMap[$paramKey] = preg_replace('/(^{)|(}$)/','', $param);
            }
        }
    }

    private function makeRegexRequest()
    {
        $requestUriArray = explode('/', $this->requestURI);

        foreach($this->paramMap as $paramKey => $param)
        {
            if(!isset($requestUriArray[$paramKey]))
            {
                return;
            }
            $this->paramRequestMap[$param] = $requestUriArray[$paramKey];
            $requestUriArray[$paramKey] = '{.*}';
        }
        $this->requestURI = implode('/',$requestUriArray);
        $this->prepareRegex();

    }

    private function prepareRegex()
    {
        $this->requestURI = str_replace('/', '\/', $this->requestURI);
    }

    private function run()
    {
        if(preg_match("/$this->requestURI/", $this->routeConfiguration->route))
        {
            $this->render();
        }
    }

    private function render()
    {

        $ClassName = $this->routeConfiguration->controller;
        $action = $this->routeConfiguration->action;

        print((new $ClassName)->$action(...$this->paramRequestMap));

        die();
    }

}