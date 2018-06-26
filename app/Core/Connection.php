<?php

namespace App\Core;

use \Illuminate\Database\Capsule\Manager as Capsule;

class Connection
{
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Capsule;
            self::$instance->addConnection([
                'driver' => 'mysql',
                'host' => HOST,
                'database' => DBNAME,
                'username' => USER,
                'password' => PASS,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]);
            self::$instance->setAsGlobal();
            self::$instance->bootEloquent();
        }
        return self::$instance;
    }

    protected function __construct()
    {
        //
    }

    public function __clone()
    {
        //
    }

    public function __wakeup()
    {
        //
    }
}
