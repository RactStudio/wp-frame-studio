<?php

namespace RactStudio\FrameStudio\Api;

use WP_REST_Request;

/**
 * Framework representation of an incoming WP REST API request.
 */
class Request
{
    /**
     * The WordPress REST request instance.
     *
     * @var WP_REST_Request
     */
    protected $wpRequest;

    /**
     * Create a new request instance.
     *
     * @param WP_REST_Request $wpRequest
     */
    public function __construct(WP_REST_Request $wpRequest)
    {
        $this->wpRequest = $wpRequest;
    }

    /**
     * Get all input from the request.
     *
     * @return array
     */
    public function all()
    {
        return array_merge(
            $this->wpRequest->get_params(),
            $this->wpRequest->get_body_params(),
            $this->wpRequest->get_json_params()
        );
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
        if ($key === null) {
            return $this->all();
        }

        return $this->wpRequest->get_param($key) ?? $default;
    }

    /**
     * Get a header from the request.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function header($key, $default = null)
    {
        return $this->wpRequest->get_header($key) ?? $default;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->wpRequest->get_method();
    }

    /**
     * Get the underlying WP_REST_Request instance.
     *
     * @return WP_REST_Request
     */
    public function getWpRequest()
    {
        return $this->wpRequest;
    }

    /**
     * Get a query parameter.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function query($key, $default = null)
    {
        return $this->wpRequest->get_param($key) ?? $default;
    }
}

