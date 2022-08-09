<?php 
// https://github.com/WordpressDev/php-router

class Route
{
    public $request = null;
    public $response = null;
    public $router = null;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
        $this->router = new Router($request, $response);
    }

    /**
     * Register a GET route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public function get($route, $action)
    {
        $this->register('GET', $route, $action);
    }

    /**
     * Register a POST route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public function post($route, $action)
    {
        $this->register('POST', $route, $action);
    }

    /**
     * Register a PUT route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public function put($route, $action)
    {
        $this->register('PUT', $route, $action);
    }

    /**
     * Register a DELETE route with the router.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public function delete($route, $action)
    {
        $this->register('DELETE', $route, $action);
    }

    /**
     * Register a route that handles any request method.
     *
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public function any($route, $action)
    {
        $this->register('*', $route, $action);
    }

    /**
     * Register a HTTPS route with the router.
     *
     * @param  string        $method
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public function secure($method, $route, $action)
    {
        $this->register($method, $route, $action);
    }

    /**
     * Register a route with the router.
     * 
     * @param  string        $method
     * @param  string|array  $route
     * @param  mixed         $action
     * @return void
     */
    public function register($method, $route, $action)
    {
        // If the developer is registering multiple request methods to handle
        // the URI, we'll spin through each method and register the route
        // for each of them along with each URI and action.
        if (is_array($method))
        {
            foreach ($method as $http)
            {
                $this->router->route($http, $route, $action);
            }
            return;
        }
        
        foreach ((array) $route as $uri) {
            $this->router->route($method, $uri, $action);
        }
    }
    public function is_ended()
    {
        return $this->router->routed;
    }
}