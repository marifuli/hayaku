<?php

namespace Models;
 
class Anime
{
    static $table = 'animes';

    static function table()
    {
        return \Illuminate\Database\Capsule\Manager::table(self::$table);
    }
}