<?php

function __env($key = false)
{
    $env = include(APP_PATH . 'env.php');
    if($key === false)
    {
        return $env;
    }else 
    {
        return $env[$key] ?? false;
    }
}