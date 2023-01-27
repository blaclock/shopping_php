<?php

class Router
{
    private $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function resolve($pathInfo)
    {
        $pathInfo = urldecode($pathInfo);
        // var_dump($pathInfo);
        // $path:コントローラー、$pattern:アクション
        foreach ($this->routes as $path => $pattern) {
            // if (preg_match('/^' . str_replace('/', '\/', $path) . '$/', $pathInfo)) {
            if (preg_match('/^' . str_replace('/', '\/', $path) . '$/u', $pathInfo)) {
                $pattern = str_replace('/', '\\', $pattern);
                return $pattern;
            }
        }

        // マッチするパスがなかったらfalseを返す
        return false;
    }
}
