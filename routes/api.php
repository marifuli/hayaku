<?php

Route::get('/', [Controllers\Home::class, 'index']);
Route::get('/latest-episode', [Controllers\Home::class, 'latest']);

// Route::get('/(:any)', function($hi)
// {
	
// });
