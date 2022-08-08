<?php

use App\Routes\Api;
use App\Routes\Web;

require APP_PATH . 'core/helpers.php';
require APP_PATH . 'core/routing/Route.php';
require APP_PATH . 'core/routing/Router.php';

$env_data = include(APP_PATH . 'env.php');
function __env($key, $default = null) {
    return $env_data[$key] ?? $default;
}
/**
 * Setting up the DB Connection
 */
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver'   => 'mysql',
    'host'     => 'localhost:3306',
    'database' => 'cryanime',
    'username' => 'root',
    'password' => '12345678',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'   => '',
]);
// Set the event dispatcher used by Eloquent models... (optional)
$capsule->setEventDispatcher(
    new Illuminate\Events\Dispatcher(
        new Illuminate\Container\Container
        )
);
//- query builder
$capsule->setAsGlobal();
//- Eloquent models
//$capsule->bootEloquent();



$server = new Swoole\HTTP\Server("127.0.0.1", 8081);

$server->on("start", function (Swoole\Http\Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:8081\n";
});

$server->on("request", function (Swoole\Http\Request $req, Swoole\Http\Response $res) {

    // create the router
    $router = new Route($req, $res);
    
    // run the api routes
    Api::run($router);
    Web::run($router);
    /**Add more routes here, iif you need */

    //- serve static contents
    if (getStaticFile($req, $res)) return;

    // Serve the 404 page
    if($router->is_ended() === false)
    {
        $res->status(404);
        response($res, '404 - Not Found');
    }

});
$server->start();

