<?php
namespace App\Routes;

use App\Controllers\Home;
use Route;

class Api {

    static function run(Route $router) {

        $router->get('api/', fn ($req, $res) => Home::index($req, $res));
        $router->get('api/hi', fn ($req, $res) => Home::hi($req, $res));
        $router->get('api/hii/(:any)', fn ($req, $res, $data) => $res->end('What the ' . $data));

    }
}