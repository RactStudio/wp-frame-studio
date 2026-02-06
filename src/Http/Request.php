<?php

namespace RactStudio\FrameStudio\Http;

class Request
{
    /**
     * Get the value from the request.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function input($key, $default = null)
    {
        return $_REQUEST[$key] ?? $default;
    }

    /**
     * Get all request data.
     *
     * @return array
     */
    public function all()
    {
        return $_REQUEST;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Determine if the request is an AJAX request.
     *
     * @return bool
     */
    public function ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Get the request URI.
     *
     * @return string
     */
    public function path()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = explode('?', $uri)[0];
        return trim($uri, '/');
    }
    
    /**
     * Get instance of capture request.
     * 
     * @return static
     */
    public static function capture()
    {
        return new static;
    }
}
