<?php

namespace App\Models;
 
class Anime
{
    static $table = 'users';

    static function table()
    {
        return \Illuminate\Database\Capsule\Manager::table(self::$table);
    }
}