<?php

namespace App\Core;

use \App\Models\User as User;

class Autorization
{
    public static function getLoggedUserId()
    {
        if (!isset($_COOKIE['id']) || !isset($_COOKIE['hash'])) {
            return false;
        }
        $result = User::where('id', '=', $_COOKIE['id'])
            ->where('hash', '=', $_COOKIE['hash'])
            ->first(['id']);
        if (!$result) {
            return false;
        }
        $result = $result->toArray();
        return $result['id'];
    }
}
