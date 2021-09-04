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