<?php

namespace RactStudio\FrameStudio\Http;

use Closure;
use RactStudio\FrameStudio\Foundation\Application;

class Router
{
    /**
     * The application instance.
     *
     * @var \RactStudio\FrameStudio\Foundation\Application
     */
    protected $app;

    /**
     * The registered routes.
     *
     * @var array
     */
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'PATCH' => [],
    ];

    /**
     * Create a new Router instance.
     *
     * @param  \RactStudio\FrameStudio\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @param  mixed  $action
     * @return void
     */
    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @param  mixed  $action
     * @return void
     */
    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Add a route to the underlying route collection.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  mixed  $action
     * @return void
     */
    protected function addRoute($method, $uri, $action)
    {
        $this->routes[$method][$uri] = $action;
        
        // In WP, we might also want to register rewrite rules here immediately
        // or collect them and register later on 'init'.
        // For REST routes, hook into rest_api_init.
    }

    /**
     * Dispatch the request to the application.
     *
     * @param  \RactStudio\FrameStudio\Http\Request  $request
     * @return \RactStudio\FrameStudio\Http\Response
     */
    public function dispatch(Request $request)
    {
        $method = $request->method();
        $uri = $request->path();

        if (/* exact match */ isset($this->routes[$method][$uri])) {
            return $this->runRoute($this->routes[$method][$uri], $request);
        }
        
        // Fallback for logic: 404 or pass to WordPress machinery?
        // Since we are inside WP, we might not want to return 404 immediately 
        // unless we are sure it's a route meant for us. 
        
        return null; 
    }
    
    protected function runRoute($action, $request)
    {
        if ($action instanceof Closure) {
            $content = $action();
            if (!$content instanceof Response) {
                $content = new Response($content);
            }
            return $content;
        }
        
        // Handle Controller@method string and array callables
        return new Response('Controller dispatch not implemented yet');
    }
}
