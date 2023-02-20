<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('tests', 'TestController');
Router::post('login', 'SecurityController');
Router::post('addTest', 'TestController');
Router::post('register', 'SecurityController');
Router::post('search', 'TestController');
Router::get('like', 'TestController');
Router::get('dislike', 'TestController');

Router::run($path);