<?php 

//- headers
header('Content-Type: application/json');

//- constants
define('APP_PATH', dirname(__DIR__) . '/');

//- included files
require APP_PATH . 'vendor/autoload.php';
require APP_PATH . 'app/Router/Route.php';
require APP_PATH . 'app/Router/Router.php';
require APP_PATH . 'app/helpers/config.php';
require APP_PATH . 'app/helpers/env.php';

use Illuminate\Database\Capsule\Manager as Capsule;
 
$capsule = new Capsule;
 
$capsule->addConnection([
	'driver'   => 'mysql',
	'host'     => '127.0.0.1:3306',
	'database' => 'cryanime',
	'username' => 'root',
	'password' => '',
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'   => '',
]);
// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Container\Container;
$capsule->setEventDispatcher(
	new Illuminate\Events\Dispatcher(new Container)
);
$capsule->setAsGlobal();
$capsule->bootEloquent();

require APP_PATH . 'routes/api.php';