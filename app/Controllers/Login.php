<?php

namespace App\Controllers;

use App\Core\Validation;
use App\Models\User;

class Login extends MainController
{
    const RANDOM_LENGTH = 20;

    public function index()
    {
        $loginStatus = false;
        if (!empty($_POST['name'] && !empty($_POST['password']))) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['salt'=>PASSWORD_SALT]);

            //проверяем наличие пользователя в бд по логину и паролю
            $getUserId = User::whereRaw('LOWER(name) = ?', [mb_strtolower($_POST['name'])])
                ->where('pswhash', '=', $password)
                ->first(['id']);

            if ($getUserId) {
                $getUserId = $getUserId->toArray();
                $userId = $getUserId['id'];
                $hash = bin2hex(random_bytes(self::RANDOM_LENGTH));

                //заношу в бд рандомную строку и передаю ее в куку
                User::where('id', '=', $userId)->update(['hash' => $hash]);
                setcookie('id', $userId, 0, '/');
                setcookie('hash', $hash, 0, '/');
                $loginStatus = true;
            }
        }
        $this->view->render('login/index', 'template', ['loginStatus'=>$loginStatus]);
    }

    public function register()
    {
        $registerStatus = false;
        $errors = [];

        if (!empty($_POST)) {
            //валидация полей для записи в БД
            if (!Validation::checkPasswords($_POST['password'], $_POST['password2'])) {
                $errors[] = Validation::ERROR_DIF_PASSWORDS;
            }
            if (!Validation::checkName($_POST['name'])) {
                $errors[] = Validation::ERROR_NAME;
            }
            if (!Validation::checkAge($_POST['age'])) {
                $errors[] = Validation::ERROR_AGE;
            }
            if (!Validation::checkPassword($_POST['password'])) {
                $errors[] = Validation::ERROR_PASSWORD;
            }
            if (!$errors) {
                //проверяем наличие пользователя в бд по логину
                $getUserId = User::whereRaw('LOWER(name) = ?', [$_POST['name']])->first(['id']);

                if (!$getUserId) {
                    //заношу нового пользователя в БД
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['salt'=>PASSWORD_SALT]);
                    $user = new User();
                    $user->name = $_POST['name'];
                    $user->age = $_POST['age'];
                    $user->pswhash = $password;
                    if ($user->save()) {
                        $userId = $user->id;
                        //заношу в бд рандомную строку и передаю ее в куку
                        $hash = bin2hex(random_bytes(self::RANDOM_LENGTH));
                        User::where('id', '=', $userId)->update(['hash' => $hash]);
                        setcookie('id', $userId, 0, '/');
                        setcookie('hash', $hash, 0, '/');
                        $registerStatus = true;
                    }
                } else {
                    $errors[] = Validation::ERROR_USER_EXIST;
                }
            }
        }

        $this->view->render('login/register', 'template', ['registerStatus'=>$registerStatus, 'errors'=>$errors]);
    }
}
