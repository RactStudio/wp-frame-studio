<?php

namespace RactStudio\FrameStudio\Http;

/**
 * Wraps raw PHP request data, provides sanitization and accessors.
 */
class WpRequest
{
    /**
     * The sanitized GET parameters.
     *
     * @var array
     */
    protected $get = [];

    /**
     * The sanitized POST parameters.
     *
     * @var array
     */
    protected $post = [];

    /**
     * The sanitized FILES parameters.
     *
     * @var array
     */
    protected $files = [];

    /**
     * The sanitized SERVER parameters.
     *
     * @var array
     */
    protected $server = [];

    /**
     * Create a new request instance.
     */
    public function __construct()
    {
        $this->get = $this->sanitizeArray($_GET ?? []);
        $this->post = $this->sanitizeArray($_POST ?? []);
        $this->files = $_FILES ?? [];
        $this->server = $_SERVER ?? [];
    }

    /**
     * Get input from the request.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function input($key = null, $default = null)
    {
        $all = array_merge($this->get, $this->post);

        if ($key === null) {
            return $all;
        }

        return $all[$key] ?? $default;
    }

    /**
     * Get a GET parameter.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * Get a POST parameter.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function post($key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * Get a file from the request.
     *
     * @param string $key
     * @return array|null
     */
    public function file($key)
    {
        return $this->files[$key] ?? null;
    }

    /**
     * Get all files from the request.
     *
     * @return array
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * Get a server variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function server($key, $default = null)
    {
        return $this->server[$key] ?? $default;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->server('REQUEST_METHOD', 'GET');
    }

    /**
     * Check if the request is a POST request.
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->method() === 'POST';
    }

    /**
     * Check if the request is a GET request.
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->method() === 'GET';
    }

    /**
     * Sanitize an array of input data.
     *
     * @param array $data
     * @return array
     */
    protected function sanitizeArray(array $data)
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            $sanitized[sanitize_key($key)] = $this->sanitizeValue($value);
        }

        return $sanitized;
    }

    /**
     * Sanitize a single value.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function sanitizeValue($value)
    {
        if (is_array($value)) {
            return $this->sanitizeArray($value);
        }

        if (is_string($value)) {
            return sanitize_text_field($value);
        }

        return $value;
    }
}

