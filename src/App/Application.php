<?php

class Application
{
    public function __construct()
    {
        $this->router = new Router($this->registerRoutes());
    }

    public function run()
    {
        $params = $this->router->resolve($this->getPathInfo());
        $controller = $params['controller'];
        $action = $params['action'];
        $this->runAction($controller, $action);
    }

    private function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        $controller = new $controllerClass;
        $controller->run($action);
    }

    private function registerRoutes()
    {
        // ルーティングのパターンを登録
        return [
            '/' => ['controller' => 'Product', 'action' => 'index']
        ];
    }

    private function getPathInfo()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
