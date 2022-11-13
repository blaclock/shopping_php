<?php

require __DIR__ . '/../vendor/autoload.php';

// .envファイルの内容を取得
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// オートロード
require 'core/AutoLoader.php';
$loader = new AutoLoader();
$loader->registerDir(__DIR__ . '/core');
$loader->registerDir(__DIR__ . '/controllers');
$loader->registerDir(__DIR__ . '/models');
$loader->register();

//
const APP_DIR = '/Users/kuroiwatomohiro/Documents/code/shopping/src/App/';
const TMP_DIR = APP_DIR . 'resources/views/';

// Twigの設定
// $loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
// $twig = new \Twig_Environment($loader, [
//     'cache' => Bootstrap::CACHE_DIR,
// ]);
