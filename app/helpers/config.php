<?php 

function config ($key = false)
{
    $app_config = include(APP_PATH . 'config/app.php');
    if($key === false)
    {
        return $app_config;
    }else 
    {
        return $app_config[$key] ?? false;
    }
}