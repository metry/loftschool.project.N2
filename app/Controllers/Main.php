<?php

namespace App\Controllers;

class Main extends MainController
{
    public function index()
    {
        echo 'Hello world! It`s main page! Default Main controller and action index';
    }

    public function test()
    {
        //$model = new \App\Models\MainModel(); для подключения бд
        $this->view->render('test', 'template', ['project'=>'mvc', 'date'=>'06 2018']);
    }
}
