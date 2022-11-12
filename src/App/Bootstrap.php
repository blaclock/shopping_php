<?php

require 'core/AutoLoader.php';

$loader = new AutoLoader();
$loader->registerDir(__DIR__ . '/core');
$loader->registerDir(__DIR__ . '/controllers');
$loader->registerDir(__DIR__ . '/test');
$loader->register();
