<?php
require 'vendor/autoload.php';

//dump($_SERVER);//var_dump
//dd($_SERVER);//var_dump et die

/**@var Altorouer */
$router = new AltoRouter();

// map homepage
$router->map( 'GET', '/', function() {
    require 'home.php';
});

// map userspage /!_ attention ordre
$router->map( 'GET', '/categories/', function() {
    require 'categories.php';
});

// map postspage /!_ attention ordre
$router->map( 'GET', '/articles/[i:id]', function() {
    require 'posts.php';
});

// assuming current request url = '/'
$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    exit();
}