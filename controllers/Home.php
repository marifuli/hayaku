<?php
namespace Controllers;

use Models\Anime;

class Home 
{
    public function index()
    {
        return Anime::table()->limit(10)->get();
    }
    public function latest()
    {
        $page = request('page');
        
    }
}
