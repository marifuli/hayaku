<?php
namespace Controllers;

use Models\Anime;

class Home 
{
    static function index($req, $res)
    {
        response($res, 'Hello world = ' . time());
    }
    static function hi($req, $res)
    {
        return response($res, Anime::table()->limit(1)->get());
    }
}
