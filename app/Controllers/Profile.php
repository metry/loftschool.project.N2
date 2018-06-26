<?php

namespace App\Controllers;

use App\Core\Upload;
use App\Core\Validation;
use \App\Models\User;
use \App\Models\File;
use \App\Core\Autorization;

class Profile extends MainController
{
    const IMG_DIR = 'img';
    const IMG_PROFILE_DIR = 'profiles';
    const IMG_FILES_DIR = 'files';

    public function index()
    {
        if (!$userId = Autorization::getLoggedUserId()) {
            $this->view->render('nologged', 'template');
            return false;
        };

        $data = User::where('id', '=', $userId)->first(['id', 'name', 'age', 'description', 'img'])->toArray();
        $fileData = File::where('user_id', '=', $userId)->get()->toArray();

        $this->view->render('profile/index', 'template', [
            'userInfo'=>$data,
            'userId'=>$userId,
            'fileData'=>$fileData
        ]);
        return null;
    }

    public function addfile()
    {
        if (!$userId = Autorization::getLoggedUserId()) {
            $this->view->render('nologged', 'template');
            return false;
        };

        $errors = [];

        if (!empty($_FILES['document']['name'])) {
             //Проверяю пути на существование
            if (!file_exists($path = self::IMG_DIR)) {
                mkdir($path);
            }
            if (!file_exists($path = self::IMG_DIR . '/'  . self::IMG_FILES_DIR)) {
                mkdir($path);
            }
            if (!file_exists($path = self::IMG_DIR . '/'  . self::IMG_FILES_DIR . '/' . $userId)) {
                mkdir($path);
            }

            $imgUploader = new Upload();
            $imgUploader->setDestination($path);
            $imgUploader->setMaxSize('5242880');
            $imgUploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'doc', 'csv', ]);
            $imgUploader->setAllowedMimeTypes([
                'image/jpeg',
                'image/png',
                'application/msword',
                'text/csv',
                'text/plain'
            ]);
            $uploadStatus = $imgUploader->upload($_FILES['document']);
            if ($uploadStatus['status']) {
                //добавляю информацию о документе в БД
                $file = new File();
                $file->user_id = $userId;
                $file->file = $uploadStatus['filename'];
                $file->save();
            } else {
                $errors[] = $uploadStatus['error'];
            }
        }


        $fileData = File::where('user_id', '=', $userId)->get()->toArray();
        $this->view->render('profile/addfile', 'template', [
            'userId'=>$userId,
            'fileData'=>$fileData,
            'errors'=>$errors
        ]);
        return null;
    }

    public function edit($parametres)
    {
        if (!$userId = Autorization::getLoggedUserId()) {
            $this->view->render('nologged', 'template');
            return false;
        };

        //получаю Id редактируемого пользователя
        $userId = ($parametres[0] > 0) ? $userId = (int)$parametres[0] : $userId;

        //проверяю на наличие пользователя в БД по ID (приходящему через get)
        if (!User::where('id', '=', $userId)->first(['id'])) {
            throw new \Exception("Указанный пользователь не существует");
            return null;
        }

        $errors = [];

         //Обновление аватара
        if (!empty($_FILES['logo']['name'])) {
            //Проверяю пути на существование
            if (!file_exists($path = self::IMG_DIR)) {
                mkdir($path);
            }
            if (!file_exists($path = self::IMG_DIR . '/'  . self::IMG_PROFILE_DIR)) {
                mkdir($path);
            }
            if (!file_exists($path = self::IMG_DIR . '/'  . self::IMG_PROFILE_DIR . '/' . $userId)) {
                mkdir($path);
            }

            $imgUploader = new Upload();
            $imgUploader->setDestination($path);
            $imgUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
            $imgUploader->setAllowedMimeTypes(['image/jpeg', 'image/png']);
            $uploadStatus = $imgUploader->upload($_FILES['logo']);
            if ($uploadStatus['status']) {
                User::where('id', '=', $userId)->update(['img' => $uploadStatus['filename']]);
            } else {
                $errors[] = $uploadStatus['error'];
            }
        }
         //Проверка текстовых данных формы
        $pageUpdate = false;

        if (!empty($_POST)) {
            if (!Validation::checkName($_POST['name'])) {
                $errors[] = Validation::ERROR_NAME;
            }
            if (!Validation::checkAge($_POST['age'])) {
                $errors[] = Validation::ERROR_AGE;
            }
            if (!$errors) {
                //проверяем наличие пользователя в бд по логину
                $getUserId = User::whereRaw('LOWER(name) = ?', [$_POST['name']])->first(['id']);
                if ($getUserId) {
                    $getUserId = $getUserId->toArray();
                    $getUserId = $getUserId['id'];
                }
                if (!$getUserId || $getUserId==$userId) {
                    //обновляю пользователя
                    User::where('id', '=', $userId)->update([
                        'name' => $_POST['name'],
                        'age' => $_POST['age'],
                        'description' => $_POST['description']
                    ]);
                } else {
                    $errors[] = Validation::ERROR_USER_EXIST;
                }
            }
        }

        $data = User::where('id', '=', $userId)->first(['id', 'name', 'age', 'description', 'img'])->toArray();

        $this->view->render('profile/edit', 'template', [
            'userInfo'=>$data,
            'userId'=>$userId,
            'pageUpdate'=>$pageUpdate,
            'errors'=>$errors
        ]);
        return null;
    }
}
