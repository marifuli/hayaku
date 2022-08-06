<?php


function request($key = false)
{
    if(!$key)
    {
        return (object) $_REQUEST;
    }
    if(isset($_REQUEST[$key]))
    {
        return $_REQUEST[$key];
    }

    return false;
}


if(!function_exists('__env'))
{
    function __env($key = false)
    {
        $env = include('env.php');
        if($key === false)
        {
            return $env;
        }else 
        {
            return $env[$key] ?? false;
        }
    }    
}

function getStaticFile($request, $response) : bool 
{
    if( strlen($request->server['request_uri'] < 2) ) return false;
    $staticFile = __DIR__ .'/../static'. $request->server['request_uri'];
    if (! file_exists($staticFile)) {
        return false;
    }
    $response->header('Content-Type', mime_content_type($staticFile));
    $response->sendfile($staticFile);
    $request->ended = true;
    return true;
}