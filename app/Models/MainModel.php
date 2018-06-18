<?php
namespace App\Models;

class MainModel
{
    protected $dbConnection;

    public function __construct()
    {
        $this->dbConnection = \App\Core\Connection::getInstance();
    }
}
