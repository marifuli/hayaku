<?php
namespace Controllers;

use Models\Anime;

class Home 
{
    public function index($req, $res)
    {
        return 'Hello world!';
        // return Anime::table()->limit(10)->get();
    }
    public function index2($req, $res)
    {
        // return 'Hello world!';
        return Anime::table()->limit(10)->get();
    }
    public function latest()
    {
        $page = request('page');
    }
}
