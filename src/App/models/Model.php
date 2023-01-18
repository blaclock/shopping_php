<?php

namespace App\models;

class Model extends PDODatabase
{
    protected $db;
    protected $models;

    public function __construct()
    {
        $this->connectDB();
    }

    protected function connectDB()
    {
        $this->db = new PDODatabase(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
            $_ENV['DB_NAME'],
            $_ENV['DB_TYPE']
        );
    }

    public function get($modelName)
    {
        if (!isset($this->models[$modelName])) {
            $modelName = '\\App\\models\\' . $modelName;
            $model = new $modelName();
            $this->models[$modelName] = $model;
        }

        return $this->models[$modelName];
    }

    public function __destruct()
    {
        $this->db = null;
    }
}
