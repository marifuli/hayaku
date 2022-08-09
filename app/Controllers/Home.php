<?php
namespace App\Controllers;

use \App\Models\Anime;

class Home 
{
    static function index($req, $res)
    {
        // var_dump($req->main->header);
        // $res->set_header('Authorization', 'Bearer.ergseuyerg5437587w3b5f34');
        $res->send('Hello world = ' . time() . __env('name'));
    }
}
