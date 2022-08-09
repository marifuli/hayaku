<?php
class Response 
{
    public $main = null;
    function __construct(Swoole\Http\Response $res)
    {
        $this->main = $res;
    }
    public function set_header(array|string $headers, $val= null)
    {
        if(gettype($headers) == 'string' && $val)
        {
            $this->main->header($headers, $val);
        }else 
        {
            foreach ($headers as $key => $value)
            {
                $this->main->header($key, $value);
            }
        }
    }
    public function set_cookie ($name, $value, $expire = 0, $path = '/', $domain = null, $secure = false)
    {
        $string = $name . "=" . urlencode($value) . "; " . ($secure ? 'Secure; ' : '') 
        . 'Path=' . $path. '; Expires=' . gmdate('D, d M Y H:i:s \G\M\T', $expire);
        $this->main->header('Set-Cookie', $string);
    }
    public function send ($data)
    {
        if(gettype($data) !== 'string')
        {
            $data = json_encode($data);
            $this->main->header('Content-Type', 'application/json');
        }
        $this->main->end($data);
    }
}