<?php
namespace App;

use \PDO;

class Connection
{
    //new PDO("mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE') . ";charset=UTF8", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
    public static function getPDO(): PDO
    {
        return  new PDO(
            "mysql:host=" .
                getenv('MYSQL_HOST') .
                ";dbname=" . getenv('MYSQL_DATABASE'),
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD')
        );
    }
}