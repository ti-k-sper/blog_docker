<?php
namespace App\Model\Table;

use \App\Controller\Database\DatabaseController;

class Table
{
    protected $db;

    protected $table;

    public function __construct(DatabaseController $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            //               get_class = recup namespace  $this = PostTable
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name));
        }
    }
}