<?php
namespace App\Controllers;

use App\Core\View;

class MainController
{
    protected $view;
    public function __construct()
    {
        $this->view = new View();
    }

    public function defaultAction()
    {
        echo 'Hi! It`s default action from MainController!';
    }
}
