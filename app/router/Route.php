<?php 

//- Documentation
/**
 * https://github.com/WordpressDev/php-router
 */

class Route
{

    /**
     * Register a GET route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function get($route, $action, $req, $res)
    {
        static::register('GET', $route, $action, $req, $res);
    }

    /**
     * Register a POST route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function post($route, $action, $req, $res)
    {
        static::register('POST', $route, $action, $req, $res);
    }

    /**
     * Register a PUT route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function put($route, $action, $req, $res)
    {
        static::register('PUT', $route, $action, $req, $res);
    }

    /**
     * Register a DELETE route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function delete($route, $action, $req, $res)
    {
        static::register('DELETE', $route, $action, $req, $res);
    }

    /**
     * Register a route that handles any request method.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function any($route, $action, $req, $res)
    {
        static::register('*', $route, $action, $req, $res);
    }

    /**
     * Register a HTTPS route with the router.
     *
     * @param  string        $method
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function secure($method, $route, $action, $req, $res)
    {
        // stop when not secure
        if (!Router::secure())
            return;
        
        static::register($method, $route, $action, $req, $res);
    }

    /**
     * Register a route with the router.
     * 
     * @param  string        $method
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function register($method, $route, $action, $req, $res)
    {
        // If the developer is registering multiple request methods to handle
        // the URI, we'll spin through each method and register the route
        // for each of them along with each URI and action.
        if (is_array($method))
        {
            foreach ($method as $http)
            {
                Router::route($http, $route, $action, $req, $res);
            }
            return;
        }
        
        foreach ((array) $route as $uri) {
            Router::route($method, $uri, $action, $req, $res);
        }
    }

}