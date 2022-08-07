<?php 
require 'helpers.php';
require 'routing/Route.php';
require 'routing/Router.php';

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

