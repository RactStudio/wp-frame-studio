<?php

namespace RactStudio\FrameStudio\Http\Security;

/**
 * Helper for creating and verifying WordPress nonces.
 */
class Nonce
{
    /**
     * Create a nonce.
     *
     * @param string $action
     * @return string
     */
    public static function create($action = -1)
    {
        return wp_create_nonce($action);
    }

    /**
     * Verify a nonce.
     *
     * @param string $nonce
     * @param string $action
     * @return bool
     */
    public static function verify($nonce, $action = -1)
    {
        return wp_verify_nonce($nonce, $action) !== false;
    }

    /**
     * Get a nonce field for forms.
     *
     * @param string $action
     * @param string $name
     * @param bool $referer
     * @return string
     */
    public static function field($action = -1, $name = '_wpnonce', $referer = true)
    {
        return wp_nonce_field($action, $name, $referer, false);
    }

    /**
     * Get a nonce URL.
     *
     * @param string $actionurl
     * @param string $action
     * @param string $name
     * @return string
     */
    public static function url($actionurl, $action = -1, $name = '_wpnonce')
    {
        return wp_nonce_url($actionurl, $action, $name);
    }

    /**
     * Verify a nonce from a request.
     *
     * @param string $action
     * @param string $name
     * @return bool
     */
    public static function verifyRequest($action = -1, $name = '_wpnonce')
    {
        $nonce = $_REQUEST[$name] ?? '';

        return self::verify($nonce, $action);
    }
}

