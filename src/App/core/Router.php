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
        // $path:コントローラー、$pattern:アクション
        foreach ($this->routes as $path => $pattern) {
            if ($path === $pathInfo) {
                return $pattern;
            }
        }

        // マッチするパスがなかったらfalseを返す
        return false;
    }
}
