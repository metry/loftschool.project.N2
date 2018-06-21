<?php

namespace App\Controllers;

class Main extends MainController
{
    public function index()
    {
        echo 'Hello world! It`s main page! Default Main controller and action index. ';
        echo 'Go to a <a href="/main/test">test project</a>.';
    }

    public function test()
    {
        $this->view->render('test', 'template', ['project'=>'mvc', 'date'=>'06 2018']);
    }
}
