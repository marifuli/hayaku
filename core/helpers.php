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
function response ($response, $data, $headers = [])
{
    foreach ($headers as $key => $value)
    {
        $response->main->header($key, $value);
    }
    if(gettype($data) !== 'string')
    {
        $data = json_encode($data);
        $response->main->header('Content-Type', 'application/json');
    }
    $response->main->end($data);
}


function getStaticFile($request, $response) : bool 
{
    if( strlen($request->server['request_uri'] < 2) ) return false;
    $staticFile = APP_PATH . 'public'. $request->server['request_uri'];
    if (! file_exists($staticFile)) {
        return false;
    }
    $response->header('Content-Type', mime_content_type($staticFile));
    $response->sendfile($staticFile);
    return true;
}