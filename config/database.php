<?php


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
$capsule->setEventDispatcher(
	new Illuminate\Events\Dispatcher(
		new Illuminate\Container\Container
		)
);

//- query builder
$capsule->setAsGlobal();

//- Eloquent models
//$capsule->bootEloquent();

