<?php 
class Request 
{
    public $main = null;
    function __construct(Swoole\Http\Request $req)
    {
        $this->main = $req;
    }
    public function get_header($key = false)
    {
        if($key)
        {
            return $this->main->header[strtolower($key)];
        }
        return $this->main->header ?? false;
    }
    public function get_cookie($key = false)
    {
        if($key)
        {
            return $this->main->cookie[strtolower($key)];
        }
        return $this->main->cookie ?? false;
    }
}