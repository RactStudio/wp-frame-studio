<?php

namespace RactStudio\FrameStudio\Api;

use WP_REST_Response;
use WP_Error;

/**
 * Helper class for standardized API response generation.
 */
class Response
{
    /**
     * Create a JSON response.
     *
     * @param mixed $data
     * @param int $status
     * @param array $headers
     * @return WP_REST_Response
     */
    public static function json($data, $status = 200, array $headers = [])
    {
        $response = new WP_REST_Response($data, $status);

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }

    /**
     * Create a success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return WP_REST_Response
     */
    public static function success($data = null, $message = 'Success', $status = 200)
    {
        return static::json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Create an error response.
     *
     * @param string $message
     * @param mixed $errors
     * @param int $status
     * @return WP_REST_Response
     */
    public static function error($message = 'Error', $errors = null, $status = 400)
    {
        $data = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $data['errors'] = $errors;
        }

        return static::json($data, $status);
    }

    /**
     * Create a WP_Error response.
     *
     * @param string $code
     * @param string $message
     * @param array $data
     * @return WP_Error
     */
    public static function wpError($code, $message, array $data = [])
    {
        return new WP_Error($code, $message, $data);
    }
}

