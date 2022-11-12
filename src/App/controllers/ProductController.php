<?php

class ProductController
{
    public function run($action)
    {
        $this->$action();
    }

    public function index()
    {
        echo 'ProductController';
    }
}
