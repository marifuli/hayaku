<?php 
//- Documentation
/**
 * https://github.com/WordpressDev/php-router
 */

class Router
{

    /**
     * The URI for the current request.
     *
     * @var string
     */
    public static $uri;

    /**
     * The base URL for the current request.
     *
     * @var string
     */
    public static $base;

    /**
     * Was the user routed yet?
     */
    private static $routed = FALSE;

    /**
     * Get the URI for the current request.
     *
     * @return string
     */
    public static function uri( $req )
    {        
        // Detect URI using PATH_INFO
        $uri = $req->server['path_info'];
        
        // Remove leading and trailing slashes
        $uri = trim($uri, '/');
        
        if ($uri == '')
        {
            $uri = '/';
        }
        
        return $uri;
    }

    /**
     * Get the base URL for the current request.
     *
     * @return string
     */
    public static function base($uri = '')
    {
        if (!is_null(static::$base))
            return static::$base . $uri;
        
        if (isset($_SERVER['HTTP_HOST']))
        {
            static::$base = Router::secure() ? 'https' : 'http';
            static::$base .= '://' . $_SERVER['HTTP_HOST'];
            static::$base .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        }
        else
        {
            static::$base = 'http://localhost/';
        }
        
        return static::$base . $uri;
    }

    /**
     * Check if the the request is requested by HTTPS 
     *
     * @return bool
     */
    public static function secure()
    {
        return true; // !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
    }

    /**
     * Match the route and execute the action
     * 
     * @param  string  $method
     * @param  string  $route
     * @param  mixed   $action
     * @return void
     */
    public static function route($method, $route, $action, $req, $res)
    {
        // If a previous route was matched, we can skip all routes with a lower
        // priority.
        // if (static::$routed)
        // {
        //     return;
        // }
        
        // We can ignore this route if the request method does not match
        if ($method != '*' && strtoupper($method) != $req->server['request_method'])
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
        if ($route == static::uri($req))
        {
            static::call($action, [], $req, $res);
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
            if (preg_match('#^' . $route . '$#', static::uri($req), $parameters))
            {
                static::call($action, array_slice($parameters, 1), $req, $res);
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
    private static function call($action, $parameters = array(), $req, $res)
    {
        $parameters[] = $req;
        $parameters[] = $res;
        if (is_callable($action))
        {
            // The action is an anonymous function, let's execute it.
            $response = call_user_func_array($action, $parameters);
            if(is_array($response) || is_object($response))
            {
                $res->end( json_encode($response) );
            }else 
            if(is_string($response))
            {
                $res->end( $response );
            }
            else 
            {
                $res->end( $response );
            }
        }
        else 
        {
            if (is_string($action) && strpos($action, '@'))
            {
                list($controller, $method) = explode('@', $action);
                $class = basename($controller);    
            }
            else
            if(is_array($action) && count($action) == 2)
            {
                $class = $action[0];
                $method = $action[1];
            }
            else 
            {
                echo "Controller or method doesn't exist - From app/Router/Router.php";
                exit;
            }
            
            
            // Controller delegates may use back-references to the action parameters,
            // which allows the developer to setup more flexible routes to various
            // controllers with much less code than would be usual.
            if (strpos($method, '(:') !== FALSE)
            {
                foreach ($parameters as $key => $value)
                {
                    $method = str_replace('(:' . ($key + 1) . ')', $value, $method, $count);
                    if ($count > 0)
                    {
                        unset($parameters[$key]);
                    }
                }
            }
            
            // Default controller method if left empty.
            if (!$method)
            {
                $method = 'index';
            }
            
            // Load the controller class file if needed.
            // if (!class_exists($class))
            // {
            //     if (file_exists(APP_PATH . "controllers/$controller.php"))
            //     {
            //         include (APP_PATH . "controllers/$controller.php");
            //     }
            // }
            
            // The controller class was still not found. Let the next routes handle the
            // request.
            if (!class_exists($class))
            {
                return;
            }
            
            $instance = new $class();
            $res->end( call_user_func_array(array($instance, $method), $parameters) );
        }
        
        // The current route was matched. Ignore new routes.
    }
}
