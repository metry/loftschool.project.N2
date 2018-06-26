<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Core\Autorization;

class Information extends MainController
{
    const ASC_SORT = 'asc';
    const DESC_SORT = 'desc';
    const ADULT_AGE = 18;
    //занес alias'ы в контроллер, только из-за условия задачи. Проверку лучше делать в виде.
    const ADULT_ALIAS = 'Cовершеннолетний';
    const MINOR_ALIAS = 'Несовершеннолетний';

    public function index($parametres)
    {
        if (!Autorization::getLoggedUserId()) {
            $this->view->render('nologged', 'template');
            return false;
        };

        $data = (mb_strtolower($parametres[0]) == self::DESC_SORT) ?
            User::all()->sortByDesc('age')->toArray() :
            User::all()->sortBy('age')->toArray();

        $data = array_map(
            function ($item) {
                    $item['adult'] = ($item['age'] < self::ADULT_AGE) ? self::MINOR_ALIAS : self::ADULT_ALIAS;
                    return $item;
            },
            $data
        );
        $this->view->render('information/index', 'template', ['usersInfo'=>$data]);
        return null;
    }
}
