<?php
namespace App\Controllers;

use \App\Models\Anime;

class Home 
{
    static function index($req, $res)
    {
        response($res, 'Hello world = ' . time() . __env('name'));
    }
    static function hi($req, $res)
    {
        return response($res, Anime::table()->limit(1)->get());
    }
}
