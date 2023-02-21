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

    protected function setPagination($Num, $perPage = 8)
    {
        // 商品数を１ページに表示する商品数で割った商を切り上げ
        $pageNum = (int)ceil($Num / $perPage);
        $pageNum = ($pageNum === 0) ? 1 : $pageNum;

        if ($pageNum === 1) {
            return ['pageNum' => 1];
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $position = ($page > 1) ? ($page * $perPage) - $perPage : 0;

        $this->db->setLimitOff($perPage, $position);

        return [
            'pageNum' => $pageNum,
            'Num' => $Num,
            'present' => $page,
            'url' => $this->setPaginationUrl()
        ];
    }

    private function setPaginationUrl()
    {
        $queries = isset($_GET) ? $_GET : [];
        $url = '';

        foreach ($queries as $key => $query) {
            if ($key !== 'page') {
                $url .= $key . '=' . $query . '&';
            } else {
                $url .= 'page=';
            }
        }

        if (!array_key_exists('page', $queries)) {
            $url .= 'page=';
        }

        return $url;
    }

    public function __destruct()
    {
        $this->db = null;
    }
}
