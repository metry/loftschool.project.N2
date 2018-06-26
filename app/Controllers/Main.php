<?php

namespace App\Controllers;

use App\Core\Validation;
use App\Models\File;
use App\Models\User;

class Main extends MainController
{
    public function index()
    {
        echo 'Hello world! It`s main page! Default Main controller and action index. ';
        echo 'Go to a <a href="/main/test">test page of MVC-project</a>.';
        echo '<br><br>';
        echo 'To add ' . COUNT_FAKE_USERS . ' fake users go to <a href="/main/faker">faker page</a>.';
    }

    public function test()
    {
        $this->view->render('test', 'template', ['project'=>'mvc', 'date'=>'06 2018']);
    }

    public function faker()
    {
        $faker = \Faker\Factory::create();
        for ($userIter = 1; $userIter <= COUNT_FAKE_USERS; $userIter++) {
            //Add User data
            $userName = $faker->userName;
            $age = $faker->numberBetween(Validation::MIN_AGE, Validation::MAX_AGE);
            $description = $faker->text(255);
            $password = password_hash(DEFAULT_PASSWORD, PASSWORD_DEFAULT, ['salt'=>PASSWORD_SALT]);

            $user = new User();
            $user->name = $userName;
            $user->age = $age;
            $user->pswhash = $password;
            $user->description = $description;
            if ($user->save()) {
                $userId = $user->id;
                if (!file_exists($path = Profile::IMG_DIR)) {
                    mkdir($path);
                }
                if (!file_exists($path = Profile::IMG_DIR . '/'  . Profile::IMG_PROFILE_DIR)) {
                    mkdir($path);
                }
                if (!file_exists($path = Profile::IMG_DIR . '/'  . Profile::IMG_PROFILE_DIR . '/' . $userId)) {
                    mkdir($path);
                }
                $logo = $faker->image($path, 640, 480, 'cats', false);

                User::where('id', '=', $userId)->update(['img' => $logo]);

                //Add files data
                if (!file_exists($path = Profile::IMG_DIR . '/'  . Profile::IMG_FILES_DIR . '/' . $userId)) {
                    mkdir($path);
                }
                $filesCount = $faker->numberBetween(2, 4);
                for ($iter = 1; $iter <= $filesCount; $iter++) {
                    $fileName = $faker->image($path, 640, 480, 'cats', false);
                    $file = new File();
                    $file->user_id = $userId;
                    $file->file = $fileName;
                    $file->save();
                }
                echo 'Добавлен пользователь ' . $userName;
                echo ' добавленных документов - ' . $filesCount;
                echo ' пароль для входа - ' . DEFAULT_PASSWORD;
                echo '<br>';
            }
        }
    }
}
