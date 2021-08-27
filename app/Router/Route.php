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
    public static function get($route, $action)
    {
        static::register('GET', $route, $action);
    }

    /**
     * Register a POST route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function post($route, $action)
    {
        static::register('POST', $route, $action);
    }

    /**
     * Register a PUT route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function put($route, $action)
    {
        static::register('PUT', $route, $action);
    }

    /**
     * Register a DELETE route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function delete($route, $action)
    {
        static::register('DELETE', $route, $action);
    }

    /**
     * Register a route that handles any request method.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function any($route, $action)
    {
        static::register('*', $route, $action);
    }

    /**
     * Register a HTTPS route with the router.
     *
     * @param  string        $method
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function secure($method, $route, $action)
    {
        // stop when not secure
        if (!Router::secure())
            return;
        
        static::register($method, $route, $action);
    }

    /**
     * Register a controller with the router.
     *
     * @param  string|array  $controllers
     * @param  string|array  $defaults
     * @return void
     */
    public static function controller($controllers, $defaults = 'index')
    {
        Router::controller($controllers, $defaults);
    }

    /**
     * Register a route with the router.
     * 
     * @param  string        $method
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public static function register($method, $route, $action)
    {
        // If the developer is registering multiple request methods to handle
        // the URI, we'll spin through each method and register the route
        // for each of them along with each URI and action.
        if (is_array($method))
        {
            foreach ($method as $http)
            {
                Router::route($http, $route, $action);
            }
            return;
        }
        
        foreach ((array) $route as $uri) {
            Router::route($method, $uri, $action);
        }
    }

}