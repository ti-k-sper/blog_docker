<?php
namespace App\Controller\Database;

use \PDO;

class DatabaseController
{
    private $pdo;

    function __construct(string $db_name,
                        string $db_user = 'root',
                        string $db_pass = 'root',
                        string $db_host = 'localhost',
                        string $db_char = 'UTF8')
    {
        $this->db_name = $db_name;//getenv('MYSQL_DATABASE')
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->db_char = $db_char;
    }
    
    public function getPDO(): PDO
    {
        if (is_null($this->pdo)){
            $pdo = new PDO(
                "mysql:host=" . $this->db_host .";
                dbname=" . $this->db_name,
                $this->db_user,
                $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->$pdo;
    }
}