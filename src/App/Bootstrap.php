<?php

require __DIR__ . '/../vendor/autoload.php';

// .envファイルの内容を取得
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// オートロード
require 'core/AutoLoader.php';
$loader = new App\core\AutoLoader();
$loader->registerDir(__DIR__ . '/core');
$loader->registerDir(__DIR__ . '/controllers');
$loader->registerDir(__DIR__ . '/controllers/Admin');
$loader->registerDir(__DIR__ . '/controllers/auth');
$loader->registerDir(__DIR__ . '/models');
$loader->registerDir(__DIR__ . '/consts');
$loader->register();
