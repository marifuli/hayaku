<?php

use Controllers\Home;

function run_api(Route $router) {

    $router->get('/', fn ($req, $res) => Home::index($req, $res));
    $router->get('hi', fn ($req, $res) => Home::hi($req, $res));
    $router->get('hii/(:any)', fn ($req, $res, $data) => $res->end('What the ' . $data));

}