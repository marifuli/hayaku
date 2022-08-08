<?php 
// https://github.com/WordpressDev/php-router

class Router
{

    /**
     * The URI for the current request.
     *
     * @var string
     */
    public $uri = '';

    /**
     * The base URL for the current request.
     *
     * @var string
     */
    public $base = '';

    /**
     * Was the user routed yet?
     */
    public $routed = FALSE;

    public $request = null;
    public $response = null;

    public function __construct(Swoole\Http\Request $request, Swoole\Http\Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * Get the URI for the current request.
     *
     * @return string
     */
    public function uri()
    {
        
        if (isset($this->request->server['request_uri']))
        {
            // Detect using request_uri, this works in most situations.
            $this->uri = $this->request->server['request_uri'];
            
            // Remove the query string.
            if (($pos = strpos($this->uri, '?')) !== false)
            {
                $this->uri = substr($this->uri, 0, $pos);
            }
        }
        else if (isset($this->request->server['path_info']))
        {
            // Detect URI using path_info
            $this->uri = $this->request->server['path_info'];
        }
        
        // Remove leading and trailing slashes
        $this->uri = trim($this->uri, '/');
        
        if ($this->uri == '')
        {
            $this->uri = '/';
        }
        
        return $this->uri;
    }

    /**
     * Get the request method for the current request.
     *
     * @return string
     */
    public function method()
    {
        return strtoupper($this->request->server['request_method']);
    }

    /**
     * Match the route and execute the action
     * 
     * @param  string  $method
     * @param  string  $route
     * @param  mixed   $action
     * @return void
     */
    public function route($method, $route, $action)
    {
        // If a previous route was matched, we can skip all routes with a lower
        // priority.
        if ($this->routed)
        {
            return;
        }
        
        // We can ignore this route if the request method does not match
        if ($method != '*' && strtoupper($method) != $this->method())
        {
            return;
        }
        
        $route = trim($route, '/');
        
        if ($route == '')
        {
            $route = '/';
        }
        
        // Of course literal route matches are the quickest to find, so we will
        // check for those first. If the destination key exists in the routes
        // array we can just return that route now.
        if ($route == $this->uri())
        {
            $this->call($action);
            return;
        }
        
        // We only need to check routes with regular expression since all others
        // would have been able to be matched by the search for literal matches
        // we just did before we started searching.
        if (strpos($route, '(') !== FALSE)
        {
            $patterns = array(
                '(:num)' => '([0-9]+)', 
                '(:any)' => '([a-zA-Z0-9\.\-_%=]+)', 
                '(:all)' => '(.*)', 
                '/(:num?)' => '(?:/([0-9]+))?', 
                '/(:any?)' => '(?:/([a-zA-Z0-9\.\-_%=]+))?', 
                '/(:all?)' => '(?:/(.*))?'
            );
            
            $route = str_replace(array_keys($patterns), array_values($patterns), $route);
            
            // If we get a match we'll return the route and slice off the first
            // parameter match, as preg_match sets the first array item to the
            // full-text match of the pattern.
            if (preg_match('#^' . $route . '$#', $this->uri(), $parameters))
            {
                $this->call($action, array_slice($parameters, 1));
                return;
            }
        }
    }

    /**
     * Execute an action matched by the router
     *
     * @param  mixed   $action
     * @param  mixed   $parameters
     * @return void
     */
    public function call($action, $parameters = array())
    {
        $parameters[] = $this->request;
        $parameters[] = $this->response;

        if (is_callable($action))
        {
            // The action is an anonymous function, let's execute it.
            call_user_func_array($action, [
                $this->request, $this->response,
                ... $parameters
            ]);
        }
        
        // The current route was matched. Ignore new routes.
        $this->routed = TRUE;
    }


}