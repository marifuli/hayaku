<?php

namespace App\Models;
 
class Episode
{
    static $table = 'episodes';

    static function table()
    {
        return \Illuminate\Database\Capsule\Manager::table(self::$table);
    }
}