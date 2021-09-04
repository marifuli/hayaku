<?php 

$startTime = microtime(true);

//- headers
header('Content-Type: application/json');

//- constants
define('APP_PATH', dirname(__DIR__) . '/');


//- included files
require APP_PATH . 'vendor/autoload.php';
require APP_PATH . 'app/Router/Route.php';
require APP_PATH . 'app/Router/Router.php';
require APP_PATH . 'app/helpers/config.php';
require APP_PATH . 'app/helpers/helpers.php';
require APP_PATH . 'app/helpers/env.php';
require APP_PATH . 'config/database.php';

//- load the routes
require APP_PATH . 'routes/api.php';



//echo "<br> Time:  " . (number_format(( microtime(true) - $startTime), 4) * 1000) . " ms\n";