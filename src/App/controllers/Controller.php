<?php

namespace App\controllers;

use \HttpNotFoundException;
use \View;

class Controller
{
    protected $request;
    protected $model;

    public function __construct($application)
    {
        $this->request = $application->getRequest();
        $this->model = $application->getModel();
    }

    public function run($action)
    {
        // 指定されたアクションのメソッドがコントローラーに登録されていなかったら
        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException();
            exit();
        }
        session_start();
        $this->$action();
    }

    public function view(string $filePath, array $variables)
    {
        $view = new View();
        $view->view($filePath, $variables);
    }
}
