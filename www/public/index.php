<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;//DIRECTORY_SEPARATOR => / sur linux et \ sur windows

require_once $basePath . 'vendor/autoload.php';


$router = new App\Router($basePath . 'views');

$router->get('/', 'index', 'home')
    ->get('/categories', 'categories', 'categories')
    ->get('/article/[*:slug]-[i:id]', 'post/post', 'post')
    ->run();
