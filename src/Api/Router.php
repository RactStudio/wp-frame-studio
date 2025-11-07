<?php

namespace RactStudio\FrameStudio\Api;

use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

/**
 * Registers custom WP REST API endpoints with clean, expressive syntax.
 */
class Router
{
    /**
     * Registered routes.
     *
     * @var array
     */
    protected $routes = [];

    /**
     * The namespace for all routes.
     *
     * @var string
     */
    protected $namespace = 'wp-frame-studio/v1';

    /**
     * Global middleware for all routes.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Create a new router instance.
     *
     * @param string|null $namespace
     */
    public function __construct($namespace = null)
    {
        if ($namespace) {
            $this->namespace = $namespace;
        }
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param callable|array $callback
     * @param array $options
     * @return void
     */
    public function get($uri, $callback, array $options = [])
    {
        $this->addRoute(['GET'], $uri, $callback, $options);
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param callable|array $callback
     * @param array $options
     * @return void
     */
    public function post($uri, $callback, array $options = [])
    {
        $this->addRoute(['POST'], $uri, $callback, $options);
    }

    /**
     * Register a PUT route.
     *
     * @param string $uri
     * @param callable|array $callback
     * @param array $options
     * @return void
     */
    public function put($uri, $callback, array $options = [])
    {
        $this->addRoute(['PUT'], $uri, $callback, $options);
    }

    /**
     * Register a PATCH route.
     *
     * @param string $uri
     * @param callable|array $callback
     * @param array $options
     * @return void
     */
    public function patch($uri, $callback, array $options = [])
    {
        $this->addRoute(['PATCH'], $uri, $callback, $options);
    }

    /**
     * Register a DELETE route.
     *
     * @param string $uri
     * @param callable|array $callback
     * @param array $options
     * @return void
     */
    public function delete($uri, $callback, array $options = [])
    {
        $this->addRoute(['DELETE'], $uri, $callback, $options);
    }

    /**
     * Register a route that responds to multiple HTTP methods.
     *
     * @param array $methods
     * @param string $uri
     * @param callable|array $callback
     * @param array $options
     * @return void
     */
    public function match(array $methods, $uri, $callback, array $options = [])
    {
        $this->addRoute($methods, $uri, $callback, $options);
    }

    /**
     * Add a route to the router.
     *
     * @param array $methods
     * @param string $uri
     * @param callable|array $callback
     * @param array $options
     * @return void
     */
    protected function addRoute(array $methods, $uri, $callback, array $options = [])
    {
        $uri = trim($uri, '/');
        $route = [
            'methods' => $methods,
            'uri' => $uri,
            'callback' => $callback,
            'options' => $options,
            'middleware' => array_merge($this->middleware, $options['middleware'] ?? []),
        ];

        $this->routes[] = $route;
    }

    /**
     * Register all routes with WordPress REST API.
     *
     * @return void
     */
    public function register()
    {
        add_action('rest_api_init', function () {
            foreach ($this->routes as $route) {
                register_rest_route($this->namespace, '/' . $route['uri'], [
                    'methods' => $route['methods'],
                    'callback' => function (WP_REST_Request $request) use ($route) {
                        return $this->handleRequest($request, $route);
                    },
                    'permission_callback' => $route['options']['permission_callback'] ?? '__return_true',
                    'args' => $route['options']['args'] ?? [],
                ]);
            }
        });
    }

    /**
     * Handle a REST API request.
     *
     * @param WP_REST_Request $request
     * @param array $route
     * @return WP_REST_Response|WP_Error
     */
    protected function handleRequest(WP_REST_Request $request, array $route)
    {
        // Apply middleware
        foreach ($route['middleware'] as $middleware) {
            $result = $this->runMiddleware($middleware, $request);
            if ($result instanceof WP_Error || $result instanceof WP_REST_Response) {
                return $result;
            }
        }

        // Execute callback
        $callback = $route['callback'];
        
        if (is_array($callback) && count($callback) === 2) {
            [$class, $method] = $callback;
            $instance = new $class();
            return $instance->$method($request);
        }

        if (is_callable($callback)) {
            return call_user_func($callback, $request);
        }

        return new WP_Error('invalid_callback', 'Invalid route callback');
    }

    /**
     * Run middleware.
     *
     * @param string|callable $middleware
     * @param WP_REST_Request $request
     * @return mixed
     */
    protected function runMiddleware($middleware, WP_REST_Request $request)
    {
        if (is_string($middleware)) {
            $middleware = new $middleware();
        }

        if (is_callable($middleware)) {
            return call_user_func($middleware, $request);
        }

        if (method_exists($middleware, 'handle')) {
            return $middleware->handle($request);
        }

        return null;
    }

    /**
     * Set global middleware.
     *
     * @param array $middleware
     * @return void
     */
    public function middleware(array $middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * Set the namespace for routes.
     *
     * @param string $namespace
     * @return void
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }
}

