<?php
function run_api($req, $res) {

    Route::get('/hi', [Controllers\Home::class, 'index'], $req, $res);
    Route::get('/hi/(:any)', [Controllers\Home::class, 'index2'], $req, $res);

    // Route::get('/(:any)', function($hi)
    // {
        
    // }, $req, $res);

}