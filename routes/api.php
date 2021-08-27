<?php

use Illuminate\Database\Capsule\Manager;

Route::get('/', function () {
    return Manager::table('users')->limit(10)->get();
});


// Route::get('/(:any)', function($hi)
// {
	
// });
